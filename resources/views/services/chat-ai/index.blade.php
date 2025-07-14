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

                <div class="bg-slate-800 rounded-xl py-4 mb-6">
                    <div id="chatMessages" class="space-y-4 max-h-[80vh] overflow-y-auto px-4 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-700">
                        @if ($history && count($history))
                            @foreach ($history as $item)
                                @if ($item['role'] === 'user')
                                    <div class="flex justify-end">
                                        <div class="bg-violet-500/40 text-violet-100 rounded-lg text-sm p-4 max-w-[80%]">
                                            <strong class="block mb-1 text-violet-200 text-right">You</strong>
                                            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-violet-400 scrollbar-track-violet-600/30">
                                                <div class="inline-block py-4 whitespace-nowrap">
                                                    {!! \Illuminate\Support\Str::markdown($item['content']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex justify-start">
                                        <div class="bg-pink-500/30 text-pink-100 text-left rounded-lg text-sm p-4 w-full">
                                            <strong class="block text-pink-200">AI</strong>
                                            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-pink-400 scrollbar-track-pink-600/30">
                                                <div class="inline-block py-4 whitespace-nowrap">
                                                    {!! \Illuminate\Support\Str::markdown($item['content']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                    <div class="bg-violet-500/40 text-violet-100 rounded-lg text-sm p-4 max-w-[80%]">
                        <strong class="block mb-1 text-violet-200 text-right">You</strong>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-violet-400 scrollbar-track-violet-600/30">
                            <div class="inline-block py-4 whitespace-nowrap">
                                ${marked.parse(text)}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-start">
                    <div class="bg-pink-500/30 text-pink-100 text-left rounded-lg text-sm p-4 w-full">
                        <strong class="block text-pink-200">AI</strong>
                        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-pink-400 scrollbar-track-pink-600/30">
                            <div class="inline-block py-4 whitespace-nowrap">
                                ${marked.parse(data.reply)}
                            </div>
                        </div>
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
