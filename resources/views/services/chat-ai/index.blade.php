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

            <div id="result" class="mt-8 bg-slate-700 p-4 rounded-xl shadow text-white hidden leading-relaxed whitespace-pre-line"></div>
        </div>
    </section>

    <script>
        const form = document.getElementById('chatForm');
        const resultDiv = document.getElementById('result');
        const submitBtn = document.getElementById('submitBtn');

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function formatReply(text) {
            let escaped = escapeHtml(text);

            // Handle bold **text**
            escaped = escaped.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

            // Handle italic *text*
            escaped = escaped.replace(/\*(.*?)\*/g, "<em>$1</em>");

            // Handle inline code `text`
            escaped = escaped.replace(/`([^`]+?)`/g, "<code class='bg-gray-800 text-green-400 px-1 rounded'>$1</code>");

        // Handle code block ```...```
        escaped = escaped.replace(/```([\s\S]*?)```/g, "<pre class='bg-gray-800 text-green-300 p-3 rounded overflow-x-auto mb-4'><code>$1</code></pre>");

        // Handle unordered lists - item
        escaped = escaped.replace(/(?:^|\n)- (.*?)(?=\n|$)/g, "<li>$1</li>");
        if (escaped.includes("<li>")) {
            escaped = escaped.replace(/(<li>.*?<\/li>)+/gs, (match) => `<ul class="list-disc pl-5 space-y-1 mb-4">${match}</ul>`);
        }

        // Handle ordered lists 1. item
        escaped = escaped.replace(/(?:^|\n)\d+\. (.*?)(?=\n|$)/g, "<li>$1</li>");
        if (escaped.includes("<li>")) {
            escaped = escaped.replace(/(<li>.*?<\/li>)+/gs, (match) => `<ol class="list-decimal pl-5 space-y-1 mb-4">${match}</ol>`);
        }

        // Handle paragraphs and line breaks
        escaped = escaped.replace(/\n{2,}/g, "<br><br>"); // double newline → paragraph
        escaped = escaped.replace(/\n/g, "<br>"); // single newline → line break

        return `<strong class="text-pink-400">AI:</strong><br>${escaped}`;
    }

    form.addEventListener("submit", async function(e) {
        e.preventDefault();
        const text = document.getElementById("text").value;
        if (!text.trim()) return;

        resultDiv.classList.remove("hidden");
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
            if (!response.ok) throw new Error(data.message || "Something went wrong");

            resultDiv.innerHTML = formatReply(data.reply);

        } catch (error) {
            resultDiv.innerHTML = `<span class="text-red-400">Error: ${error.message}</span>`;
            }

            submitBtn.disabled = false;
        });
    </script>
@endsection
