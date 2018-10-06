(function() {
    document.querySelector('.control').addEventListener('click', e => {
        e.target.parentElement.classList.toggle('open');
    });
    [...document.querySelectorAll('.plus')].forEach(el => {
        el.addEventListener('click', () => {
            const input= el.parentElement.querySelector('input');
            input.value = Math.min(+input.value + 1, 99);
        });
    });
    [...document.querySelectorAll('.minus')].forEach(el => {
        el.addEventListener('click', () => {
            const input= el.parentElement.querySelector('input');
            input.value = Math.max(+input.value - 1, 0);
        });
    });
})();