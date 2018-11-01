(function () {
    const form = document.forms[0];
    const pay_btn = document.querySelector('.pay-button');
    const warning = document.querySelector('.warning');

    function show_warning(msg) {
        warning.style.display = 'block';
        warning.firstElementChild.textContent = msg;
        return setTimeout(() => {
            warning.classList.add('closing');
            setTimeout(() => {
                warning.classList.remove('closing');
                warning.style.display = 'none';
            }, 300);
        }, 3000);
    }

    function validate_name() {
        return /^[a-zA-Z\s]+$/.test(form.name.value);
    }

    function validate_email() {
        return /^[\w\.]+@(\w+\.){1,3}\w{2,3}$/.test(form.email.value);
    }

    function validate_form() {
        pay_btn.disabled = !validate_name() || !validate_email();
    }

    async function makePayment() {
        const fd = new FormData();
        fd.append('name', form.name.value);
        fd.append('email', form.email.value);
        const res = await fetch('api/rest/makeBooking.php', {
            method: 'post',
            body: fd
        });
        const data = await res.json();
        if (data.success) {
            show_modal();
        } else {
            show_modal(data.error);
        }
    }

    function show_modal(error) {
        const modal = document.createElement('section');
        modal.classList.add('modal');
        const modal_content = document.createElement('div');
        modal.appendChild(modal_content);
        modal_content.classList.add('modal_content');
        modal_content.innerHTML = error ? `
                   <div class="icon failure"></div>
                   <h3>Payment Failed</h3>
                   <p>${error}</p>
                   <div class="buttons">
                       <a href="home.php" class="raised-button"><span>home</span></a>
                       <a href="showtime.php" class="raised-button primary"><span>retry</span></a>
                   </div>` : `
                  <div class="icon success"></div>
                   <h3>Payment Successful</h3>
                   <p>You will receive a confirmation email for your bookings.</p>
                   <div class="buttons">
                       <a href="home.php" class="raised-button"><span>home</span></a>
                       <a href="user.php" class="raised-button primary"><span>check</span></a>
                   </div>`;
        document.querySelector('main').appendChild(modal);
        document.body.style.overflow = 'hidden';
    }

    form.name.addEventListener('blur', () => {
        validate_name() || show_warning('Name must contain alphabets and space only!');
        validate_form();
    });
    form.email.addEventListener('blur', () => {
        validate_email() || show_warning('Email format is invalid!');
        validate_form();
    });
    form.name.addEventListener('change', validate_form);
    form.email.addEventListener('change', validate_form);

    pay_btn.addEventListener('click', makePayment);

    [...document.querySelectorAll('i[data-id]')].forEach(el => {
        el.parentElement.addEventListener('click', e => e.stopPropagation());
        el.addEventListener('click', async (e) => {
            e.stopPropagation();
            const data = {
                type: 'REMOVE_SHOWTIME',
                showtime: el.dataset.id
            };
            const parent = e.target.parentElement.parentElement;
            const movie = parent.firstElementChild.textContent.split('x')[0].split('-')[1].trim();
            if(!confirm(`Do you want to delete bookings for 🎬${movie}?`)) {
                return;
            }
            const req = await fetch('api/rest/updateBooking.php', {
                body: JSON.stringify(data),
                method: 'post'
            });
            const result = await req.json();
            if (result.success) {
                while (parent.nextElementSibling && parent.nextElementSibling.classList.contains('sub')) {
                    parent.parentElement.removeChild(parent.nextElementSibling);
                }
                parent.parentElement.removeChild(parent);
            }
            if (document.querySelectorAll('.header:not(.combo)').length < 3) {
                [...document.querySelectorAll('.header')].forEach(h => h.classList.add('expanded'));
            }
        });
    });

    [...document.querySelectorAll('i[data-combo]')].forEach(el => {
        el.parentElement.addEventListener('click', e => e.stopPropagation());
        el.addEventListener('click', async (e) => {
            e.stopPropagation();
            const type = e.target.dataset.combo;
            const data = {
                type: 'UPDATE_COMBO',
                ['combo_' + type]: 0
            };
            if(!confirm(`Do you want to delete ${type == 'a' ? '🍿' : '🌭'}Combo ${type.toUpperCase()}?`)) {
                return;
            }
            const req = await fetch('api/rest/updateBooking.php', {
                body: JSON.stringify(data),
                method: 'post'
            });
            const result = await req.json();
            const parent = e.target.parentElement.parentElement;
            if (result.success) {
                while (parent.nextElementSibling && parent.nextElementSibling.classList.contains('sub')) {
                    parent.parentElement.removeChild(parent.nextElementSibling);
                }
                parent.parentElement.removeChild(parent);
            }
        });
    });

})();