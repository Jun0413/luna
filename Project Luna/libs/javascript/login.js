const form = document.getElementsByClassName('login-modal-content')[0];

function displaySignin() {
    document.getElementsByClassName('login-input')[0].style.opacity = 0;
    setTimeout(_ => {
        document.getElementsByClassName('login-input')[0].innerHTML = document.getElementById('login-input-signin').innerHTML;
        document.getElementsByClassName('login-input')[0].style.opacity = 1;
    }, 500);
}

function displaySignup() {
    document.getElementsByClassName('login-input')[0].style.opacity = 0;
    setTimeout(_ => {
        document.getElementsByClassName('login-input')[0].innerHTML = document.getElementById('login-input-signup').innerHTML;
        document.getElementsByClassName('login-input')[0].style.opacity = 1;
    }, 500);
}

function processResult(result) {
    const success = result.success;
    if (success) {
        // reload and display name from session
        location.reload();
    } else {
        alert(result.error);
    }
}

async function signin_handler() {
    const fd = new FormData();
    fd.append('email', form.email.value);
    fd.append('password', form.password.value);
    fd.append('byLoginForm', form.byLoginForm.value);
    const res = await fetch("api/rest/verifyUser.php", {
        method: 'post',
        body: fd
    });
    const result = await res.json();
    processResult(result);
}

async function signup_handler() {
    const fd = new FormData();
    fd.append('name', form.name.value);
    fd.append('email', form.email.value);
    fd.append('password', form.password.value);
    fd.append('byLoginForm', form.byLoginForm.value);
    const res = await fetch("api/rest/registerUser.php", {
        method: 'post',
        body: fd
    });
    const result = await res.json();
    processResult(result);
}

window.onload = () => {
    displaySignin();
}
