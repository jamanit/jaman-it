<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use Throwable;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class WordToPdfController extends Controller
{
    public function index(Request $request)
    {
        $service = Service::where('slug', 'word-to-pdf')->first();

        if ($service) {
            $cookieName = 'viewed_service_' . $service->id;
            if (!$request->cookie($cookieName)) {
                $service->increment('view_total');
                Cookie::queue($cookieName, true, 10);
            }
        }

        return view('services.word-to-pdf.index');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'word_files' => 'required',
            'word_files.*' => 'mimes:doc,docx|max:5120'
        ]);

        try {
            $files = $request->file('word_files');

            if (count($files) === 1) {
                return $this->convertSingleFile($files[0]);
            }

            return $this->convertMultipleFiles($files);
        } catch (Throwable $e) {
            Log::error('File conversion failed.', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'convert' => 'Sorry, we couldn’t convert your files right now. Please try again later.'
            ]);
        }
    }

    protected function convertSingleFile($file)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slugName = 'converted-' . Str::slug($originalName) . '.pdf';

        $cloudconvert = new CloudConvert([
            'api_key' => env('CLOUDCONVERT_API_KEY'),
            'sandbox' => false,
        ]);

        $job = (new Job())
            ->addTask(new Task('import/upload', 'import-file'))
            ->addTask(
                (new Task('convert', 'convert-file'))
                    ->set('input', 'import-file')
                    ->set('input_format', $file->getClientOriginalExtension())
                    ->set('output_format', 'pdf')
                    ->set('engine', 'libreoffice')
            )
            ->addTask(
                (new Task('export/url', 'export-my-file'))
                    ->set('input', 'convert-file')
            );

        $job = $cloudconvert->jobs()->create($job);

        $uploadTask = collect($job->getTasks())
            ->firstWhere(fn($task) => $task->getName() === 'import-file');

        if (!$uploadTask) {
            throw new \Exception('Upload task not found in job.');
        }

        $tempPath = $file->store('word-to-pdf', 'public');
        $absolutePath = storage_path('app/public/' . $tempPath);
        $cloudconvert->tasks()->upload($uploadTask, fopen($absolutePath, 'r'));

        $cloudconvert->jobs()->wait($job);
        $finishedJob = $cloudconvert->jobs()->get($job->getId());

        foreach ($finishedJob->getTasks() as $task) {
            if ($task->getStatus() === 'error') {
                throw new \Exception("Task {$task->getName()} failed: " . $task->getMessage());
            }
        }

        $exportTask = collect($finishedJob->getTasks())
            ->firstWhere(fn($task) => $task->getName() === 'export-my-file');

        if (!$exportTask) {
            throw new \Exception('Export task not found.');
        }

        $result = $exportTask->getResult();

        if (!isset($result->files[0]->url)) {
            throw new \Exception('File URL not found in export task.');
        }

        $fileUrl = $result->files[0]->url;
        $pdfContents = file_get_contents($fileUrl);

        Storage::disk('public')->delete($tempPath);

        return response($pdfContents, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"$slugName\""
        ]);
    }

    protected function convertMultipleFiles($files)
    {
        $cloudconvert = new CloudConvert([
            'api_key' => env('CLOUDCONVERT_API_KEY'),
            'sandbox' => false,
        ]);

        $tempDir = 'word-to-pdf';
        Storage::disk('public')->makeDirectory($tempDir);

        $zipFileName = 'converted-files-' . time() . '.zip';
        $zipPath = storage_path('app/public/' . $tempDir . '/' . $zipFileName);

        $zip = new ZipArchive();
        $zipStatus = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if ($zipStatus !== TRUE) {
            throw new \Exception('Failed to create zip file. Error code: ' . $zipStatus);
        }

        $successCount = 0;

        foreach ($files as $file) {
            try {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $slugName = 'converted-' . Str::slug($originalName) . '.pdf';

                $job = (new Job())
                    ->addTask(new Task('import/upload', 'import-file'))
                    ->addTask(
                        (new Task('convert', 'convert-file'))
                            ->set('input', 'import-file')
                            ->set('input_format', $file->getClientOriginalExtension())
                            ->set('output_format', 'pdf')
                            ->set('engine', 'libreoffice')
                    )
                    ->addTask(
                        (new Task('export/url', 'export-my-file'))
                            ->set('input', 'convert-file')
                    );

                $job = $cloudconvert->jobs()->create($job);

                $uploadTask = collect($job->getTasks())
                    ->firstWhere(fn($task) => $task->getName() === 'import-file');

                if (!$uploadTask) {
                    throw new \Exception('Upload task not found in job.');
                }

                $tempPath = $file->store($tempDir, 'public');
                $absolutePath = storage_path('app/public/' . $tempPath);
                $cloudconvert->tasks()->upload($uploadTask, fopen($absolutePath, 'r'));

                $cloudconvert->jobs()->wait($job);
                $finishedJob = $cloudconvert->jobs()->get($job->getId());

                foreach ($finishedJob->getTasks() as $task) {
                    if ($task->getStatus() === 'error') {
                        throw new \Exception("Task {$task->getName()} failed: " . $task->getMessage());
                    }
                }

                $exportTask = collect($finishedJob->getTasks())
                    ->firstWhere(fn($task) => $task->getName() === 'export-my-file');

                if (!$exportTask) {
                    throw new \Exception('Export task not found.');
                }

                $result = $exportTask->getResult();

                if (!isset($result->files[0]->url)) {
                    throw new \Exception('File URL not found in export task.');
                }

                $fileUrl = $result->files[0]->url;
                $pdfContents = file_get_contents($fileUrl);

                if ($zip->addFromString($slugName, $pdfContents)) {
                    $successCount++;
                }

                Storage::disk('public')->delete($tempPath);
            } catch (\Exception $e) {
                Log::error('Error converting file: ' . $file->getClientOriginalName(), [
                    'message' => $e->getMessage()
                ]);
                continue;
            }
        }

        if ($zipStatus === TRUE) {
            $zip->close();
        }

        if ($successCount === 0) {
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            throw new \Exception('No files were successfully converted.');
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }
}
