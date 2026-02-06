import './bootstrap';
// resources/js/app.js
import { gsap } from 'gsap';

// Make gsap available globally so x-init can use it directly
window.gsap = gsap;

import { Observer } from 'tailwindcss-intersect';
 
Observer.start();