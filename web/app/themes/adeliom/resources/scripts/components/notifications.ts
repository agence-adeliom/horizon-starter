type ToastType = 'success' | 'error' | 'info';

interface Toast {
    id: number;
    type: ToastType;
    title: string | null;
    content: string | null;
}

interface NotificationsStore {
    items: Toast[];
    add(toast: Omit<Toast, 'id'>): void;
    remove(id: number): void;
}

const STORE_NAME = 'notifications';
const AUTO_DISMISS_MS = 5000;

let counter = 0;

const push = (type: ToastType, title: string | null, content: string | null): void => {
    if (typeof window.Alpine === 'undefined') {
        return;
    }

    const store = window.Alpine.store(STORE_NAME) as NotificationsStore | undefined;

    if (!store || typeof store.add !== 'function') {
        return;
    }

    store.add({ type, title, content });
};

const Notifications = {
    init: () => {
        document.addEventListener('alpine:init', () => {
            window.Alpine.store(STORE_NAME, {
                items: [] as Toast[],
                add(toast: Omit<Toast, 'id'>) {
                    const id = ++counter;
                    this.items.push({ ...toast, id });

                    setTimeout(() => this.remove(id), AUTO_DISMISS_MS);
                },
                remove(id: number) {
                    this.items = this.items.filter((t: Toast) => t.id !== id);
                },
            });
        });

        document.addEventListener('livewire:navigated', () => {
            if (typeof window.Livewire === 'undefined') {
                return;
            }

            window.Livewire.on('displaySuccessNotification', (args: { title?: string; content?: string }[]) => {
                if (args[0]?.title || args[0]?.content) {
                    Notifications.success(args[0].title ?? null, args[0].content ?? null);
                }
            });

            window.Livewire.on('displayErrorNotification', (args: { title?: string; content?: string }[]) => {
                if (args[0]?.title || args[0]?.content) {
                    Notifications.error(args[0].title ?? null, args[0].content ?? null);
                }
            });

            window.Livewire.on('displayInfoNotification', (args: { title?: string; content?: string }[]) => {
                if (args[0]?.title || args[0]?.content) {
                    Notifications.info(args[0].title ?? null, args[0].content ?? null);
                }
            });
        });
    },
    success: (title: string | null, content: string | null) => push('success', title, content),
    error: (title: string | null, content: string | null) => push('error', title, content),
    info: (title: string | null, content: string | null) => push('info', title, content),
};

export default Notifications;
