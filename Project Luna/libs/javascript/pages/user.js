window.addEventListener('load', () => {
    // get elements
    const slideshow = document.querySelector('.slider');
    const container = slideshow.firstElementChild;
    const total = container.children.length;
    const left_control = document.querySelector('.control_left');
    const right_control = document.querySelector('.control_right');
    const speed = 300;
    let current = 0;
    let step = 100 / (window.innerWidth > 960 ? 5 : 3);

    // clone nodes
    if (total > 5) {
        for(let i = 0; i < total - 1; i++) {
            container.appendChild(container.children[i].cloneNode(true));
        }
    }

    // lazy-load images
    [...container.querySelectorAll('img')].forEach(el => {
        el.src = el.src.replace('0', el.parentElement.dataset.id);
    });

    [...container.children].forEach(el => el.addEventListener('click',
        () => location.href= `movie.php?movie=${el.dataset.id}`));

    // animate function
    function keyframe(start, end) {
        container.animate([
            {transform: `translateX(-${start}%)`},
            {transform: `translateX(-${end}%`}
        ], {
            duration: speed,
            easing: 'ease-out',
            fill: 'forwards'
        });
    }

    function goNext(e) {
        if (e.target.disabled || total < 5) return;
        current %= total;
        e.target.disabled = true;
        setTimeout(() => e.target.disabled = false, speed);
        keyframe(current * step, ++current * step);
    }

    function goBack(e) {
        if (e.target.disabled || total < 5) return;
        current = current % total || total;
        e.target.disabled = true;
        setTimeout(() => e.target.disabled = false, speed);
        keyframe(current * step, --current * step);
    }

    left_control.addEventListener('click', goBack);
    right_control.addEventListener('click', goNext);

    window.addEventListener('resize', () => {
        const oldStep = step;
        step = 100 / (window.innerWidth > 960 ? 5 : 3);
        keyframe(current * oldStep, current * step);
    });

});
