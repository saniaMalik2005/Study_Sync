document.addEventListener('DOMContentLoaded', function () {

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Kono field er "invalid" chinho muche felo
    function clearInvalid(fields) {
        fields.forEach(function (field) {
            field.classList.remove('is-invalid');
        });
    }

    // ---------- Signup form ----------
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', function (event) {
            let valid = true;

            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirm = document.getElementById('confirm_password');

            clearInvalid([name, email, password, confirm]);

            if (name.value.trim().length < 2) {
                name.classList.add('is-invalid');
                valid = false;
            }
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

            clearInvalid([email, password]);

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

    // ---------- Profile: edit info form ----------
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function (event) {
            let valid = true;

            const name = document.getElementById('profile_name');
            const email = document.getElementById('profile_email');

            clearInvalid([name, email]);

            if (name.value.trim().length < 2) {
                name.classList.add('is-invalid');
                valid = false;
            }
            if (!emailPattern.test(email.value.trim())) {
                email.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // ---------- Profile: change password form ----------
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (event) {
            let valid = true;

            const current = document.getElementById('current_password');
            const newPass = document.getElementById('new_password');
            const confirm = document.getElementById('confirm_new_password');

            clearInvalid([current, newPass, confirm]);

            if (current.value === '') {
                current.classList.add('is-invalid');
                valid = false;
            }
            if (newPass.value.length < 8) {
                newPass.classList.add('is-invalid');
                valid = false;
            }
            if (confirm.value !== newPass.value || confirm.value === '') {
                confirm.classList.add('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});