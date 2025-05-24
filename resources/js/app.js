import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

window.Alpine = Alpine;

Alpine.plugin(persist);

Alpine.start();
document.addEventListener('DOMContentLoaded', () => {
    // check if the darkmode is in localstory
    const darkMode = localStorage.getItem('darkMode') === 'true';
    
    // add class if its on
    if (darkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});