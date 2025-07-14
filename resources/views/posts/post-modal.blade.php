 <div x-show="postModal" x-cloak x-transition.opacity.duration.300ms class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4">
     <div @click.away="postModal = false" class="bg-gradient-to-br from-slate-800 to-slate-900 text-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col transform transition-all duration-300 scale-95" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
         <div class="flex justify-between items-start px-6 py-4 border-b border-slate-700 flex-shrink-0">
             <h2 class="text-lg font-semibold" x-text="post.title"></h2>
             <button @click="postModal = false" class="cursor-pointer flex items-center justify-center w-10 h-10 hover:bg-slate-700 text-slate-300 hover:text-white rounded-full transition duration-200" aria-label="Close Modal">
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>
         </div>

         <div class="p-6 mb-4 overflow-y-auto space-y-4 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-950" style="max-height: calc(90vh - 80px); padding-bottom: 2rem;">
             <template x-if="post.image">
                 <img :src="post.image" alt="Image" class="w-full h-78 object-cover rounded-lg shadow-md">
             </template>
             <template x-if="post.category">
                 <span class="inline-block text-white text-xs px-2 py-1 rounded-full" :class="post.categoryColor">
                     <span x-text="post.category"></span>
                 </span>
             </template>
             <p class="text-sm text-slate-400" x-text="post.date"></p>
             <div class="text-slate-100 text-base leading-relaxed" x-html="post.content"></div>
         </div>
     </div>
 </div>
