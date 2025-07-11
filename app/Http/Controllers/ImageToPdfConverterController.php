<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ImageToPdfConverterController extends Controller
{
    public function index()
    {
        return view('services.image-to-pdf.index');
    }

    public function convert(Request $request)
    {
        try {
            $request->validate([
                'images'              => 'required|array',
                'images.*'            => 'mimes:jpg,jpeg,png,gif,bmp,webp|max:2048',
                'orientation'         => 'required|in:portrait,landscape',
                'use_margin'          => 'required|in:yes,no',
                'vertical_position'   => 'required|in:top,center,bottom',
                'horizontal_position' => 'required|in:left,center,right',
            ]);

            $imageSrcList = [];

            foreach ($request->file('images') as $index => $image) {
                // Take the contents of the file and encode it to base64
                $imageData = base64_encode(file_get_contents($image->getRealPath()));
                $imageType = $image->getClientMimeType();
                $imageSrc  = 'data:' . $imageType . ';base64,' . $imageData;

                $imageSrcList[] = $imageSrc;

                // Take the first file name to use as the PDF name.
                if ($index === 0) {
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                }
            }

            $pdf = Pdf::loadView('services.image-to-pdf.preview', [
                'images'      => $imageSrcList,
                'orientation' => $request->orientation,
                'useMargin'   => $request->use_margin === 'yes',
                'vAlign'      => $request->vertical_position,
                'hAlign'      => $request->horizontal_position,
            ])->setPaper('a4', $request->orientation);

            // Create a file name from the name of the first image
            $filename = 'converted-' . Str::slug($originalName) . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['convert' => 'Failed to convert PDF. Please try again.']);
        }
    }
}
