(function () {
    const form = document.forms[0];
    const pay_btn = document.querySelector('.raised-button');
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

        }
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

})();