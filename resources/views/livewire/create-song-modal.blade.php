<div>
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-surface-dark rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <div class="bg-white dark:bg-surface-dark px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white" id="modal-title">
                            Nova Música
                        </h3>
                        <button wire:click="close" class="text-gray-400 hover:text-gray-500">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nome da Música aaa</label>
                            <input wire:model="title" type="text" class="block w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-background-light dark:bg-background-dark text-slate-900 dark:text-white focus:ring-primary" placeholder="Ex: Oceano">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tom</label>
                            <input wire:model="key" type="text" class="block w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-background-light dark:bg-background-dark text-slate-900 dark:text-white focus:ring-primary" placeholder="Ex: G">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Observações</label>
                            <textarea wire:model="lyrics" rows="3" class="block w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-background-light dark:bg-background-dark text-slate-900 dark:text-white focus:ring-primary"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-background-dark px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button wire:click="save" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-3 bg-primary text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar Música
                    </button>
                    <button wire:click="close" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm px-4 py-3 bg-white dark:bg-surface-dark text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>