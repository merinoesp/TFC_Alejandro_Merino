document.addEventListener('DOMContentLoaded', () => {
    let form = document.getElementById('form');
    let nombreEl = document.getElementById('nombre');
    let emailEl = document.getElementById('email');
    let passwordEl = document.getElementById('password');
    let passwordRepeatEl = document.getElementById('password_repeat');
    let passwordMatchMsg = document.getElementById('password-match-msg');
    let telefonoEl = document.getElementById('telefono');

    function validarNombre() {
        let regEx = /^[a-zA-ZÀ-ÿ\s]{2,}$/;
        let esValido = regEx.test(nombreEl.value);
        nombreEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    function validarEmail() {
        let regEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let esValido = regEx.test(emailEl.value);
        emailEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    function validarPassword() {
        // Requiere minúscula, mayúscula, número y mínimo 10 caracteres
        let regEx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{10,}$/;
        let esValido = regEx.test(passwordEl.value);
        passwordEl.style.borderColor = esValido ? 'green' : 'red';
        // Revalidar coincidencia si ya hay algo en repetir
        if (passwordRepeatEl.value.length > 0) {
            validarPasswordRepeat();
        }
        return esValido;
    }

    function validarPasswordRepeat() {
        let esValido = passwordRepeatEl.value === passwordEl.value && passwordRepeatEl.value.length > 0;
        passwordRepeatEl.style.borderColor = esValido ? 'green' : 'red';
        passwordMatchMsg.style.display = 'block';
        if (esValido) {
            passwordMatchMsg.textContent = '✔ Las contraseñas coinciden';
            passwordMatchMsg.style.color = 'green';
        } else {
            passwordMatchMsg.textContent = '✖ Las contraseñas no coinciden';
            passwordMatchMsg.style.color = 'red';
        }
        return esValido;
    }

    function validarTelefono() {
        let regEx = /^[0-9]{9}$/;
        let esValido = regEx.test(telefonoEl.value);
        telefonoEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    nombreEl.addEventListener('blur', validarNombre);
    emailEl.addEventListener('blur', validarEmail);
    telefonoEl.addEventListener('blur', validarTelefono);
    passwordEl.addEventListener('blur', validarPassword);
    passwordRepeatEl.addEventListener('input', validarPasswordRepeat);
    passwordRepeatEl.addEventListener('blur', validarPasswordRepeat);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (validarNombre() && validarEmail() && validarPassword() && validarPasswordRepeat() && validarTelefono()) {
            form.submit();
        } else {
            alert("Por favor, corrige los campos en rojo.");
        }
    });
});
