<div
    x-data
    role="region"
    aria-live="polite"
    aria-label="{{ __('Notifications', 'sage') }}"
    class="notifications-container fixed bottom-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none max-w-[calc(100vw-2rem)]"
>
    <template x-for="toast in $store.notifications.items" :key="toast.id">
        <div
            class="notification pointer-events-auto bg-white shadow-lg rounded-md p-4 min-w-[280px] max-w-md flex items-start gap-3 border-l-4"
            :class="{
                'border-l-green-500': toast.type === 'success',
                'border-l-red-500': toast.type === 'error',
                'border-l-blue-500': toast.type === 'info',
            }"
            :role="toast.type === 'error' ? 'alert' : 'status'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <span x-show="toast.type === 'success'" class="text-green-500 shrink-0 mt-0.5" aria-hidden="true">
                <x-fas-circle-check class="icon-5" />
            </span>
            <span x-show="toast.type === 'error'" class="text-red-500 shrink-0 mt-0.5" aria-hidden="true">
                <x-fas-circle-exclamation class="icon-5" />
            </span>
            <span x-show="toast.type === 'info'" class="text-blue-500 shrink-0 mt-0.5" aria-hidden="true">
                <x-fas-circle-info class="icon-5" />
            </span>
            <div class="flex-1 min-w-0">
                <p x-show="toast.title" x-text="toast.title" class="font-semibold text-sm text-neutral-900"></p>
                <p x-show="toast.content" x-text="toast.content" class="text-sm text-neutral-700 mt-1"></p>
            </div>
            <button
                type="button"
                @click="$store.notifications.remove(toast.id)"
                class="ml-2 text-neutral-500 hover:text-neutral-900 shrink-0"
                aria-label="{{ __('Fermer la notification', 'sage') }}"
            >
                <x-fas-xmark class="icon-3" aria-hidden="true" />
            </button>
        </div>
    </template>
</div>
