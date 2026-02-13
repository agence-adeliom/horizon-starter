import toastr from 'toastr';
import 'toastr/build/toastr.css';

const Notifications = {
    init: undefined,
    success: undefined,
    error: undefined,
    info: undefined,
};

const setOptions = () => {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: 'toast-top-right',
        preventDuplicates: false,
        onclick: null,
        showDuration: '1000',
        hideDuration: '1000',
        timeOut: 0,
        extendedTimeOut: 0,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
    };
};

Notifications.init = () => {
    document.addEventListener('livewire:navigated', () => {
        setOptions();

        if (typeof window.Livewire !== 'undefined') {
            window.Livewire.on('displaySuccessNotification', args => {
                if (args[0] && typeof args[0] === 'object') {
                    if (args[0].title || args[0].content) {
                        Notifications.success(args[0].title || null, args[0].content || null, args[0]);
                    }
                }
            });

            window.Livewire.on('displayErrorNotification', args => {
                if (args[0] && typeof args[0] === 'object') {
                    if (args[0].title || args[0].content) {
                        Notifications.error(args[0].title || null, args[0].content || null, args[0]);
                    }
                }
            });

            window.Livewire.on('displayInfoNotification', args => {
                if (args[0] && typeof args[0] === 'object') {
                    if (args[0].title || args[0].content) {
                        Notifications.info(args[0].content || null, args[0].title || null, args[0]);
                    }
                }
            });
        }
    });
};

Notifications.success = (title: null | string, content: null | string, args: null | object = null) => {
    toastr.success(content, title, handleOverrides(args));
};

Notifications.error = (title: null | string, content: null | string, args: null | object = null) => {
    toastr.error(content, title, handleOverrides(args));
};

Notifications.info = (title: null | string, content: null | string, args: null | object = null) => {
    toastr.info(title, content, handleOverrides(args));
};

const handleOverrides = (args: null | object) => {
    const options = {};

    if (args !== null && typeof args.onClick !== 'undefined' && args.onClick === 'openAuthModal') {
        options.onclick = () => {
            // Ouvrir le modal d'authentification
        };
    }

    return options;
};

export default Notifications;
