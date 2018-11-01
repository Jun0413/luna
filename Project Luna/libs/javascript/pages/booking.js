(async function () {
    let selected_seats = [];
    const showtime_el = document.getElementById('showtime');
    const pay_btn = showtime_el.nextElementSibling;
    const warning = document.querySelector('.warning');

    // left-panel
    const panel_control = document.querySelector('.control');
    panel_control.addEventListener('click', e => {
        e.target.parentElement.classList.toggle('open');
    });
    [...document.querySelectorAll('.control-button')].forEach(el => {
        el.addEventListener('click', async () => {
            const input = el.parentElement.querySelector('input');
            const add = el.classList.contains('plus');
            const value = add ? Math.min(+input.value + 1, 99) : Math.max(+input.value - 1, 0);
            const data = {type: 'UPDATE_COMBO', 'combo_a': window.combo_a.value, 'combo_b': window.combo_b.value};
            const req = await fetch('api/rest/updateBooking.php', {body: JSON.stringify(data), method: 'post'});
            const result = await req.json();
            if (result.success) input.value = value;
            panel_control.setAttribute('data-count', parseInt(combo_a.value) + parseInt(combo_b.value));
        });
    });

    const toSet = a => a.filter((v, i, a) => a.indexOf(v) === i);
    // fetch data
    const res = await fetch('api/rest/showtime.php');
    const data = await res.json();
    showtime_el.value = document.URL.match(/showtime=(\d+)/)[1];
    let showtime = data.find(v => v.id === showtime_el.value);
    const showtimes = data.filter(v => v.mid == showtime.mid);
    showtimes.forEach(s => {
        const today = new Date();
        today.setDate(today.getDate() + (7 + s.day - today.getDay()) % 7);
        s.day = today.toDateString().slice(0, -5);
    });

    // get elements
    const cinema_el = document.querySelector("[for='cinema']");
    const day_el = document.querySelector("[for='day']");
    const time_el = document.querySelector("[for='time']");
    const elements = [cinema_el, day_el, time_el];
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

    // init content
    document.querySelector('.title').textContent = showtime.movie;
    cinema_el.nextElementSibling.value = cinema_el.firstElementChild.textContent = showtime['cinema'];
    day_el.nextElementSibling.value = day_el.firstElementChild.textContent = showtime['day'];
    time_el.nextElementSibling.value = time_el.firstElementChild.textContent = showtime['time'];

    function update_cinemas() {
        const cinemas = toSet(showtimes.map(v => v.cinema));
        generate_list(cinema_el, cinemas);
    }

    function update_day() {
        const cinema = cinema_el.nextElementSibling.value;
        const day = day_el.nextElementSibling.value;
        const days = toSet(showtimes.filter(v => !cinema || v.cinema === cinema).map(v => v.day)).sort();
        generate_list(day_el, days);
        if (!days.includes(day)) {
            day_el.nextElementSibling.value = null;
            day_el.firstElementChild.textContent = 'Choose Date';
        }
    }

    function update_time() {
        const cinema = cinema_el.nextElementSibling.value;
        const day = day_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const times = toSet(showtimes.filter(v => (!cinema || v.cinema === cinema) && (!day || v.day === day)).map(v => v.time));
        generate_list(time_el, times);
        if (!times.includes(time)) {
            time_el.nextElementSibling.value = null;
            time_el.firstElementChild.textContent = 'Choose Time';
        }
    }

    update_cinemas();
    update_day();
    update_time();
    generate_seats(showtime_el.value);

    function checkShowtime() {
        const original_showtime = showtime_el.value;
        const cinema = cinema_el.nextElementSibling.value;
        const day = day_el.nextElementSibling.value;
        const time = time_el.nextElementSibling.value;
        const result = showtimes.filter(v => v.cinema === cinema && v.day === day && v.time === time);
        showtime_el.value = result.length ? result[0]['id'] : null;
        if (showtime_el.value !== original_showtime) {
            selected_seats = [];
            pay_btn.disabled = true;
        }
        generate_seats(showtime_el.value);
    }

    function updateOccupied(num) {
        const seat = document.querySelector(`[data-seat="${num}"]`);
        seat.classList.add('active');
    }

    function show_warning() {
        warning.style.display = 'block';
        return setTimeout(() => {
            warning.classList.add('closing');
            setTimeout(()=> {
                warning.classList.remove('closing');
                warning.style.display = 'none';
            }, 300);
        }, 3000);
    }

    function selectSeat(e) {
        if (!showtime_el.value) {
           return show_warning();
        }
        e.target.classList.toggle('chosen');
        const seat = e.target.dataset.seat;
        const index = selected_seats.indexOf(seat);
        if (index === -1) {
            selected_seats.push(seat);
        } else {
            selected_seats.splice(index, 1);
        }
        window.seats.value = selected_seats;
        pay_btn.disabled = !selected_seats.length;
    }

    function reset_seats() {
        selected_seats = [];
        [...document.querySelectorAll('.layout span.chosen')].forEach(el => el.classList.remove('chosen'));
        [...document.querySelectorAll('.layout span.active')].forEach(el => el.classList.remove('active'));
    }

    async function generate_seats(showtime) {
        if (!showtime) return reset_seats();
        history.pushState(null, document.title, `${location.pathname}?showtime=${showtime}`);
        const res  = await fetch(`api/rest/checkBooking.php?showtime=${showtime}`);
        const hall = await res.json();

        const info_el = document.querySelector('.info');
        info_el.classList.remove('is_imax');
        info_el.classList.remove('is_dolby');
        info_el.firstElementChild.textContent = cinema_el.nextElementSibling.value + ' - ' + hall.name;
        info_el.classList.add(hall.is_imax ? 'is_imax' : hall.is_dolby ? 'is_dolby' : 'info');

        const layout = document.querySelector('.layout');
        layout.classList.remove('type_a');
        layout.classList.remove('type_b');
        layout.classList.add(hall.type === 'A' ? 'type_a' : 'type_b');
        layout.innerHTML = hall.type === 'A' ? create_layout_a() : create_layout_b();
        hall.occupied.forEach(updateOccupied);
        [...layout.querySelectorAll('span:not(.active)')].forEach(el => {
            el.addEventListener('click', selectSeat);
        });
        selected_seats.forEach(s => document.querySelector(`[data-seat="${s}"]`).classList.add('chosen'));
    }


    function create_layout_a() {
        const range = (n, s) => Array(n).fill(0).map((v, i) => i + (s || 1));
        const square = (r, c) => `<span data-seat='${r}${c}'></span>`;
        const block = (r, n, s) => range(n, s).map(c => square(r, c)).join('');
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        const row = r =>
            `<div class="row" data-row="${r}">
                ${block(r, rows.indexOf(r)+12)}
            </div>`;
        return rows.map(r => row(r)).join('');
    }

    function create_layout_b () {
        const range = (n, s) => Array(n).fill(0).map((v, i) => i + (s || 1));
        const square = (r, c) => `<span data-seat="${r}${c}"></span>`;
        const block = (r, n, s) => range(n, s).map(c => square(r, c)).join('');
        const row = (r, long) =>
            `<div class="row" data-row="${r}">
            ${long ? [block(r, 5, 1), block(r, 10, 6), block(r, 5, 16)].join('<b></b>') : block(r, 10)}
            </div>`;
        const front = ['A', 'B', 'C'].map(r => row(r));
        const middle = ['D', 'E', 'F', 'G', 'H', 'I'].map(r => row(r, true));
        const back = ['J'].map(r => row(r));
        return front.concat(middle).concat(back).join('\n');
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
                update_day();
                update_time();
            } else {
                update_time();
            }
            checkShowtime();
            select_el.classList.remove('active');
            e.stopPropagation();
        }));
    }
    
    document.addEventListener('click', e => {
        if (e.target.tagName !== 'INPUT') {
            elements.forEach(el => el.classList.remove('active'));
        }
    });
})();