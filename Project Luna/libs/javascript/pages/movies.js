(async function () {

    // fetch movie data
    const res = await fetch('api/rest/movies.php');
    const movies = await res.json();
    const movies_el = document.querySelector('.movies');

    // fetch popularity data
    const pop_res = await fetch('api/rest/popularity.php');
    const popularities = await pop_res.json();
    
    const filter = attr => movies.map(v => v[attr]).filter((v, i, a) => a.indexOf(v) === i);
    const options = {
        genres: ['All Genres'].concat(filter('genre')),
        regions: ['All Regions'].concat(filter('region')),
        ratings: ['All Ratings'].concat(filter('rating')),
        sorts: ['Movie Name', 'Movie Length', 'Release Date', 'Popularity']
    };

    const form = document.forms['filters'];

    // create select menu
    ['genre', 'region', 'rating', 'sort'].forEach(attr => {
        const input = form[attr];
        const label = input.previousElementSibling;

        const ul = document.createElement('ul');
        ul.classList.add('select-menu');
        ul.innerHTML = options[`${attr}s`].map(o => `<li>${o}</li>`).join('\n');

        label.appendChild(ul);
        label.addEventListener('click', () => label.classList.toggle('active'));

        [...ul.children].forEach(el => el.addEventListener('click', e => {
            label.firstElementChild.textContent = input.value = e.target.textContent;
            const active = label.querySelector('li.active');
            if (active) {
                active.classList.remove('active');
            }
            e.target.classList.add('active');
            filter_movies();
        }));
    });


    function attach_click() {
        [...document.images].forEach(img => {
            const container = img.parentElement;
            const id = container.dataset.id;
            container.addEventListener('click', () => location.href = `movie.php?movie=${id}`);
        });
    }

    function filter_movies() {
        const genre = form.genre.value;
        const region = form.region.value;
        const rating = form.rating.value;
        const sort = form.sort.value;
        const sorting = {
            'Movie Name': (a, b) => a.name > b.name ? 1 : -1,
            'Movie Length': (a, b) => a.length - b.length,
            'Release Date': (a, b) => a.id - b.id - (a.is_showing - b.is_showing) * 100,
            'Popularity': (a, b) => popularities[b.id] - popularities[a.id]
        };

        const filtered = movies.filter(v => (!genre || genre === 'All Genres' || v.genre === genre) &&
            (!region || region === 'All Regions' || v.region === region) &&
            (!rating || rating === 'All Ratings' || v.rating === rating))
            .sort(sorting[sort]);
        display_movies(filtered);
    }

    function display_movies(list) {
       movies_el.innerHTML = list.map(m =>
            `<div class="movie">
                <div class="wrapper${m.is_showing ? '' :  ' disabled'}" data-id="${m.id}" 
                     data-genre="${m.genre}" data-rating="${m.rating}">
                    <img src="./images/posters/${m.id}.jpg" class="loading" alt="${m.name}">
                </div>
                <h4>${m.name}${m.is_showing ? '' : '*'}</h4>
                <p>${m.length} min</p>
            </div>`).join('\n');
       attach_click();
    }

    function lazy_load() {
        [...document.images].forEach(img => {
           const id = img.parentElement.dataset.id;
           fetch(`images/posters/${id}.jpg`).then(() => {
               img.src = img.src.replace('0', id);
           });
        });
        attach_click();
    }

    lazy_load();

})();