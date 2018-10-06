window.addEventListener('load', () => {
    const slideshow = document.querySelector('.slideshow');
    const container = slideshow.firstElementChild;
    const {delay, speed} = slideshow.dataset;
    const totalSlides = container.childElementCount;
    container.appendChild(container.firstElementChild.cloneNode(true));
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
    }, delay);
    slideshow.addEventListener('mouseenter', () => clearInterval(timer));
    slideshow.addEventListener('mouseleave', start);
    start();
});

function clickOverview() {
    // document.getElementById('details_text').style.display = 'none';
    // document.getElementById('overview_text').style.display = 'block';
    document.getElementById('tab_name').innerHTML = 'Overview';

    // fade out
    document.getElementById('description').style.opacity = 0;

    // fade in
    setTimeout(function(){ 
        document.getElementById('description').innerHTML = document.getElementById('overview_text').innerHTML;
        document.getElementById('description').style.opacity = 1;
    }, 500);

}

function clickDetails() {
    // document.getElementById('details_text').style.display = 'block';
    // document.getElementById('overview_text').style.display = 'none';
    document.getElementById('tab_name').innerHTML = 'Details';

    // fade out
    document.getElementById('description').style.opacity = 0;

    // fade in
    setTimeout(function(){ 
        document.getElementById('description').innerHTML = document.getElementById('details_text').innerHTML;
        document.getElementById('description').style.opacity = 1;
    }, 500);
}

function clickBook(mid) {
    location.href = `showtime.php?cinema=0&movie=${mid}`;
}