window.addEventListener('load', () => {
    const slideshow = document.querySelector('.slideshow');
    const container = slideshow.firstElementChild;
    const {delay, speed} = slideshow.dataset;
    const totalSlides = container.childElementCount;
    const ul = document.createElement('ul');
    container.appendChild(container.firstElementChild.cloneNode(true));
    ul.innerHTML = '<li></li>'.repeat(totalSlides);
    slideshow.appendChild(ul);
    [...container.children].forEach(el => {
        el.src = el.dataset.src;
        el.onload = () => el.removeAttribute('data-src');
    });
    let current = 0;
    const keyframe = (start, end) => {
        container.animate([
            {transform: `translateX(-${start}%)`},
            {transform: `translateX(-${end}%`}
        ], {
            duration: +speed,
            easing: 'ease-out',
            fill: 'forwards'
        });
    };
    let timer;
    const start = () => timer = setInterval(() => {
        keyframe(current * 100, ++current * 100);
        current %= totalSlides;
        [...ul.children].forEach(el => el.classList.remove('active'));
        ul.children[current].classList.add('active');
    }, delay);
    [...ul.children].forEach((el, i) => el.addEventListener('click', e => {
        clearInterval(timer);
        keyframe(current * 100, (current = i) * 100);
        start();
        e.stopPropagation();
    }));
    slideshow.addEventListener('click', () => {
        location.href = container.children[current].dataset.target;
    });
    slideshow.addEventListener('mouseenter', () => clearInterval(timer));
    slideshow.addEventListener('mouseleave', start);
    start();
});
