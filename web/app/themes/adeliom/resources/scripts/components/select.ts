import Choices from 'choices.js';
import "choices.js/public/assets/styles/choices.css";

export const initCustomSelect = () => {
    const selects = document.querySelectorAll('.select');

    selects.forEach((select) => {
        new Choices(select, {
            searchEnabled: false,
            itemSelectText: '',
        });
    });
}