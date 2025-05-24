import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

window.Alpine = Alpine;

Alpine.plugin(persist);

Alpine.start();
document.addEventListener('DOMContentLoaded', () => {
    
    const darkMode = localStorage.getItem('darkMode') === 'true';
    
    
    if (darkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});