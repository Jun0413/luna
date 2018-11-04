const form = document.getElementsByClassName('login-modal-content')[0];

form.addEventListener('submit', e => e.preventDefault());

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
    if (!form.email.value || !form.password.value) 
        return alert("Missing input!");
    if (!/^\S+@\S+\.\S+$/.test(form.email.value))
        return alert("Invalid email format");
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
    if (!form.name.value || !form.email.value || !form.password.value)
        return alert("Missing input!");
    if (!/^[a-zA-Z0-9]{1,10}$/.test(form.name.value))
        return alert("Name must be alphanumeric within length 10");
    if (!/^\S+@\S+\.\S+$/.test(form.email.value))
        return alert("Invalid email format");
    if (!/^[a-zA-Z0-9]{6,10}$/.test(form.password.value))
        return alert("Password must be alphanumeric with length between 6 and 10 characters");
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

function logout(page) {
    console.log(1)
    location.href = `./api/rest/logoutUser.php?p=${page}`;
}

function login() {
    document.getElementById('login-modal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

window.onload = () => {
    displaySignin();
}
