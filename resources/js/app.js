import './bootstrap';
import 'flowbite';
import { initScrollSpy } from './landing';

initScrollSpy();

window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('back-to-top');
    if (!backToTop) return;

    if (window.scrollY > 300) {
        backToTop.classList.remove('opacity-0', 'invisible');
        backToTop.classList.add('opacity-100', 'visible');
    } else {
        backToTop.classList.remove('opacity-100', 'visible');
        backToTop.classList.add('opacity-0', 'invisible');
    }
});

document.getElementById('back-to-top')?.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
