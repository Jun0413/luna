window.addEventListener('load', () => {
    // get elements
    const slideshow = document.querySelector('.slideshow');
    const container = slideshow.firstElementChild;
    const {delay, speed} = slideshow.dataset;
    const totalSlides = container.childElementCount;
    container.appendChild(container.firstElementChild.cloneNode(true));

    // set up indicator
    const ul = document.createElement('ul');
    ul.innerHTML = '<li></li>'.repeat(totalSlides);
    slideshow.appendChild(ul);

    // lazy-load images
    [...container.children].forEach(el => {
        el.src = el.dataset.src;
        el.onload = () => el.removeAttribute('data-src');
    });

    // animate function
    let current = 0;
    let timer;
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

    // initialize indicator
    ul.children[current].classList.add('active');

    function start() {
        timer = timer || setInterval(() => {
            keyframe(current * 100, ++current * 100);
            current %= totalSlides;
            [...ul.children].forEach(el => el.classList.remove('active'));
            ul.children[current].classList.add('active');
        }, delay);
    }

    [...ul.children].forEach((el, i) => el.addEventListener('click', e => {
        clearInterval(timer);
        keyframe(current * 100, (current = i) * 100);
        [...ul.children].forEach(el => el.classList.remove('active'));
        ul.children[current].classList.add('active');
        start();
        e.stopPropagation();
    }));

    slideshow.addEventListener('click', () => {
        location.href = container.children[current].dataset.target;
    });
    slideshow.addEventListener('mouseenter', () => {
        clearInterval(timer);
        timer = null;
    });
    slideshow.addEventListener('mouseleave', start);
    start();
});
