window.addEventListener('load', () => {
    // get elements
    const slideshow = document.querySelector('.slider');
    const container = slideshow.firstElementChild;
    const total = container.children.length;
    const left_control = document.querySelector('.control_left');
    const right_control = document.querySelector('.control_right');
    let current = 0;

    // clone nodes
    for(let i = 0; i < total - 1; i++) {
        container.appendChild(container.children[i].cloneNode(true));
    }

    // lazy-load images
    [...container.querySelectorAll('img')].forEach(el => {
        el.src = el.src.replace('0', el.parentElement.dataset.id);
        el.onload = () => el.classList.remove('opaque');
    });

    [...container.children].forEach(el => el.addEventListener('click',
        () => location.href= `movie.php?movie=${el.dataset.id}`));

    // animate function
    function keyframe(start, end) {
        container.animate([
            {transform: `translateX(-${start}%)`},
            {transform: `translateX(-${end}%`}
        ], {
            duration: 300,
            easing: 'ease-out',
            fill: 'forwards'
        });
    }

    function goNext() {
        console.log(current);
        current %= total;
        keyframe(current * 20, ++current * 20);
    }

    function goBack() {
        console.log(current);
        current = current % total || total;
        keyframe(current * 20, --current * 20);
    }

    left_control.addEventListener('click', goBack);
    right_control.addEventListener('click', goNext);


});
