// Signup form: submit er age browser e check kora
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signupForm');
    if (!form) return;

    form.addEventListener('submit', function (event) {
        let valid = true;

        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');

        // Prottek field er "invalid" chinho age muche felo
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

        // Kono vul thakle form pathabe na
        if (!valid) {
            event.preventDefault();
        }
    });
});