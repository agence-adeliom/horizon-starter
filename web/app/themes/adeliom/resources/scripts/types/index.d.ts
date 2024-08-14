import { Alpine as AlpineType } from 'alpinejs';

declare module '*.jpg';
declare module '*.svg';
declare module '*.png';

declare global {
  interface Window {
    Alpine: AlpineType;
  }
}
