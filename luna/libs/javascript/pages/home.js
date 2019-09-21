(async function () {
    const toSet = a => a.filter((v, i, a) => a.indexOf(v) === i);
    const req = await fetch('api/rest/quickBuy.php');
    const showtimes = await req.json();

    const cinema_el = document.querySelector("[for='cinema']");
    const movie_el = document.querySelector("[for='movie']");
    const time_el = document.querySelector("[for='time']");
    const elements = [cinema_el, movie_el, time_el];
    elements.forEach(el => {
        const ul = document.createElement('ul');
        ul.classList.add('select-menu');
        el.appendChild(ul);
        el.addEventListener('click', e => {
            elements.filter(v => v !== el).forEach(el => el.classList.remove('active'));
            el.classList.toggle('active');
            e.stopPropagation();
        });
    });

    function update_cinemas() {
        const movie = movie_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const cinemas = toSet(showtimes.filter(v => (!movie || v.movie === movie) && (!time || v.time === time)).map(v => v.cinema));
        generate_list(cinema_el, cinemas);
    }

    function update_movies() {
        const cinema = cinema_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const movies = toSet(showtimes.filter(v => (!cinema || v.cinema === cinema) && (!time || v.time === time)).map(v => v.movie));
        generate_list(movie_el, movies);
    }

    function update_time() {
        const cinema = cinema_el.nextElementSibling.value;
        const movie = movie_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const times = toSet(showtimes.filter(v => (!movie || v.movie === movie) && (!cinema || v.cinema === cinema)).map(v => v.time)).sort();
        generate_list(time_el, times);
        if (!times.includes(time)) {
            time_el.nextElementSibling.value = null;
            time_el.firstElementChild.textContent = 'Choose Time';
        }
    }

    function checkShowtime() {
        const cinema = cinema_el.nextElementSibling.value;
        const movie = movie_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const result = showtimes.filter(v => v.cinema === cinema && v.movie === movie && v.time === time);
        window.showtime.value = result.length ? result[0]['id'] : null;
    }

    function generate_list(select_el, options) {
        const container = select_el.querySelector('.select-menu');
        const current = select_el.nextElementSibling.value;
        container.innerHTML = options.map(v => `<li ${v === current ? 'class="active"' : ''}>${v}</li>`).join('\n');
        [...container.children].forEach(el => el.addEventListener('click', e => {
            select_el.firstElementChild.textContent = select_el.nextElementSibling.value = e.target.textContent;
            const active = select_el.querySelector('li.active');
            if (active) {
                active.classList.remove('active');
            }
            e.target.classList.add('active');
            if (select_el.getAttribute('for') === 'cinema') {
                update_movies();
                update_time();
            } else if (select_el.getAttribute('for') === 'movie') {
                update_cinemas();
                update_time();
            } else {
                update_cinemas();
                update_movies();
            }
            checkShowtime();
            select_el.classList.remove('active');
            e.stopPropagation();
        }));
    }

    update_cinemas();
    update_movies();
    update_time();

    document.addEventListener('click', e => {
        if (e.target.tagName !== 'INPUT') {
            elements.forEach(el => el.classList.remove('active'));
        }
    });

    document.querySelector("[type='reset']").addEventListener('click', () => {
        window.showtime.value = null;
        elements.forEach(el => {
            el.nextElementSibling.value = null;
            const name = el.getAttribute('for');
            el.firstElementChild.textContent = 'Choose ' + name.slice(0, 1).toUpperCase() + name.slice(1);
            update_cinemas();
            update_time();
            update_movies();
        })
    });
})();

