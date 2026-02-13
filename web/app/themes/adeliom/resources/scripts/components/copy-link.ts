import Notifications from './notifications';

const CopyLink = {
    init: undefined,
    getAllInstances: undefined,
};

CopyLink.getAllInstances = () => {
    return Array.from(document.getElementsByClassName('copy-current-link'));
};

CopyLink.init = () => {
    document.addEventListener('livewire:navigated', () => {
        CopyLink.getAllInstances()?.forEach(instance => {
            instance.addEventListener('click', e => {
                e.preventDefault();

                // Copier le lien courant dans le presse-papier
                const currentUrl = window.location.href;
                navigator.clipboard.writeText(currentUrl);

                Notifications.success('Lien copié', 'Le lien de la page courante a été copié dans le presse-papier.');
            });
        });
    });
};

export default CopyLink;
