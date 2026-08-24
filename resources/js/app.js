import './bootstrap';
// resources/js/app.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Make gsap available globally so x-init and inline scripts can use it directly
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

import { Observer } from 'tailwindcss-intersect';
 
Observer.start();