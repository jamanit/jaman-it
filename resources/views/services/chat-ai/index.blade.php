@extends('layouts.app')

@push('title', 'Chat AI')

@section('content')
    <section class="py-24 min-h-screen text-white">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500">
                AI Assistant Chat
            </h2>

            <p class="text-center text-base text-gray-300 max-w-xl mx-auto mb-10">
                Ask anything and get help instantly from AI. Powered by OpenRouter + DeepSeek.
            </p>

            <form id="chatForm" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Your Question</label>
                    <textarea id="text" name="text" rows="4" placeholder="e.g., What is Laravel?" required class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" id="submitBtn" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-lg shadow-lg transition duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        Send Message
                    </button>
                </div>
            </form>

            <div id="result" class="mt-8 bg-slate-700 p-4 rounded-xl shadow text-white hidden"></div>
        </div>
    </section>

    <script>
        const form = document.getElementById('chatForm');
        const resultDiv = document.getElementById('result');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const text = document.getElementById('text').value;
            if (!text.trim()) return;

            resultDiv.classList.remove('hidden');
            resultDiv.innerHTML = "<span class='opacity-70'>Thinking...</span>";
            submitBtn.disabled = true;

            try {
                const response = await fetch("/chat-ai", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({
                        text
                    })
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Something went wrong');
                }

                const formattedReply = data.reply
                    .replace(/\n{2,}/g, '<br><br>')
                    .replace(/\n/g, '<br>');

                resultDiv.innerHTML = `<strong>AI:</strong><br>${formattedReply}`;

            } catch (error) {
                resultDiv.innerHTML = `<span class="text-red-400">Error: ${error.message}</span>`;
            }

            submitBtn.disabled = false;
        });
    </script>
@endsection
