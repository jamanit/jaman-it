@extends('layouts.app')

@push('title', 'Chat AI')

@section('content')
    <section class="py-24 min-h-screen">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20">
            <div class="max-w-4xl mx-auto w-full">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500">
                        AI Assistant Chat
                    </h2>
                    <form id="clearHistoryForm" method="POST" action="{{ route('chat-ai.clearHistory') }}" class="{{ !$history || !count($history) ? 'hidden' : '' }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cursor-pointer text-sm text-red-400 hover:text-red-300">
                            🗑️ Clear History
                        </button>
                    </form>
                </div>

                <div class="bg-slate-700 rounded-xl py-4 mb-6">
                    <div id="chatMessages" class="space-y-4 max-h-[80vh] overflow-y-auto px-4">
                        @if ($history && count($history))
                            @foreach ($history as $item)
                                <div class="flex {{ $item['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                                    <div class="w-full px-4 py-2 rounded-lg text-sm {{ $item['role'] === 'user' ? 'bg-blue-600 text-white text-right' : 'bg-pink-600 text-white text-left' }}">
                                        <strong class="block mb-1">{{ ucfirst($item['role']) }}</strong>
                                        <div class="prose prose-invert prose-sm max-w-none">{!! \Illuminate\Support\Str::markdown($item['content']) !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="noHistoryMessage" class="text-center text-gray-400">No chat history yet.</div>
                        @endif
                    </div>
                </div>

                <div id="result" class="mb-4 hidden text-sm text-white bg-slate-600 p-4 rounded-lg leading-relaxed whitespace-pre-line"></div>

                <form id="chatForm" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-4">
                    <label class="block text-sm font-medium mb-1">Your Question</label>
                    <textarea id="text" name="text" rows="3" placeholder="Ask me anything..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                    <div class="text-right">
                        <button type="submit" id="submitBtn" class="cursor-pointer px-5 py-2 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-lg shadow-lg transition duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('/') }}assets/marked/marked.min.js"></script>

    <script>
        const form = document.getElementById('chatForm');
        const resultDiv = document.getElementById('result');
        const submitBtn = document.getElementById('submitBtn');
        const chatMessages = document.getElementById('chatMessages');
        const clearBtn = document.getElementById('clearHistoryForm');
        const noHistoryMsg = document.getElementById('noHistoryMessage');

        form.addEventListener("submit", async function(e) {
            e.preventDefault();
            const text = document.getElementById("text").value.trim();

            if (!text) {
                resultDiv.classList.remove("hidden");
                resultDiv.innerHTML = "<span class='text-red-400'>Input cannot be empty!</span>";
                return;
            }

            resultDiv.classList.remove("hidden");
            resultDiv.innerHTML = "<span class='opacity-70'>Thinking...</span>";
            submitBtn.disabled = true;

            try {
                const response = await fetch("/chat-ai/chat", {
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
                    resultDiv.innerHTML = `<span class="text-red-400">Error: ${data.message || "Something went wrong"}</span>`;
                    return;
                }

                chatMessages.innerHTML += `
                <div class="flex justify-end">
                    <div class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg text-sm text-right">
                        <strong class="block mb-1">User</strong>
                        ${marked.parse(text)}
                    </div>
                </div>
                <div class="flex justify-start">
                    <div class="w-full px-4 py-2 bg-pink-600 text-white rounded-lg text-sm text-left">
                        <strong class="block mb-1">AI</strong>
                        ${marked.parse(data.reply)}
                    </div>
                </div>
            `;

                resultDiv.classList.add("hidden");
                document.getElementById("text").value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;

                if (noHistoryMsg) {
                    noHistoryMsg.remove();
                }

                if (clearBtn && clearBtn.classList.contains('hidden')) {
                    clearBtn.classList.remove('hidden');
                }
            } catch (error) {
                resultDiv.innerHTML = `<span class="text-red-400">Error: ${error.message}</span>`;
            }

            submitBtn.disabled = false;
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chatMessages = document.getElementById("chatMessages");
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>

    <script>
        const clearForm = document.getElementById('clearHistoryForm');
        if (clearForm) {
            clearForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Clear Chat History?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, clear it!',
                    reverseButtons: true
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const response = await fetch(this.action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            Swal.fire({
                                title: 'Cleared!',
                                text: 'Your chat history has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'Failed to clear history.', 'error');
                        }
                    }
                });
            });
        }
    </script>
@endpush
