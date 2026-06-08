document.addEventListener('DOMContentLoaded', () => {
    let form = document.getElementById('form');
    let emailEl = document.getElementById('email');
    let passwordEl = document.getElementById('password');

    function validarEmail() {
        let regEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let esValido = regEx.test(emailEl.value);
        emailEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    function validarPassword() {
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{10,}$/;
        let esValido = regex.test(passwordEl.value);
        passwordEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    emailEl.addEventListener('blur', validarEmail);
    passwordEl.addEventListener('blur', validarPassword);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (validarEmail() && validarPassword()) {
            form.submit();
        }
    });
});