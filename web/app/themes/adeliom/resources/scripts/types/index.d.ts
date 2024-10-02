import { Alpine as AlpineType } from './../../../../../../../vendor/livewire/livewire/dist/livewire.esm';

declare module '*.jpg';
declare module '*.svg';
declare module '*.png';

declare global {
    interface Window {
        Alpine: AlpineType;
    }
}
