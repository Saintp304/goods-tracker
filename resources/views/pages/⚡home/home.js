
/* 🔹 Decide images based on screen width */
const isMobile = window.matchMedia('(max-width: 767px)').matches;

const heroImages = isMobile
? [
'/img/mobile1.jpg', // mobile image 1
'/img/mobile2.jpg', // mobile image 1
'/img/mobile3.jpg', // mobile image 1
'/img/mobile4.jpg', // mobile image 1
'/img/mobile5.jpg', // mobile image 1
'/img/mobile6.jpg', // mobile image 2
]: [
'/img/desktop1.jpg', // desktop image 1
'/img/desktop2.jpg', // desktop image 1
'/img/desktop3.jpg', // desktop image 1
'/img/desktop4.jpg', // desktop image 1
'/img/desktop5.jpg', // desktop image 2
];

let index = 0;
let showingFirst = true;

const bg1 = document.getElementById('hero-bg-1');
const bg2 = document.getElementById('hero-bg-2');

if (bg1 && bg2) {
// Set initial image
bg1.style.backgroundImage = `url(${heroImages[0]})`;

setInterval(() => {
index = (index + 1) % heroImages.length;

const fadeOut = showingFirst ? bg1 : bg2;
const fadeIn  = showingFirst ? bg2 : bg1;

fadeIn.style.backgroundImage = `url(${heroImages[index]})`;

fadeOut.classList.replace('opacity-100', 'opacity-0');
fadeIn.classList.replace('opacity-0', 'opacity-100');

showingFirst = !showingFirst;
}, 7000);
}
