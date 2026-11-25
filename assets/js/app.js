document.addEventListener('DOMContentLoaded', function () {

    // ---------- Signup form ----------
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', function (event) {
            let valid = true;

            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirm = document.getElementById('confirm_password');

            [name, email, password, confirm].forEach(function (field) {
                field.classList.remove('is-invalid');
            });

            if (name.value.trim().length < 2) {
                name.classList.add('is-invalid');
                valid = false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value.trim())) {
                email.classList.add('is-invalid');
                valid = false;
            }

            if (password.value.length < 8) {
                password.classList.add('is-invalid');
                valid = false;
            }

            if (confirm.value !== password.value || confirm.value === '') {
                confirm.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // ---------- Login form ----------
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            let valid = true;

            const email = document.getElementById('email');
            const password = document.getElementById('password');

            [email, password].forEach(function (field) {
                field.classList.remove('is-invalid');
            });

            if (email.value.trim() === '') {
                email.classList.add('is-invalid');
                valid = false;
            }

            if (password.value === '') {
                password.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});