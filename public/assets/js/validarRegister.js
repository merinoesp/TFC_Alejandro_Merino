document.addEventListener('DOMContentLoaded', () => {
    let form = document.getElementById('form');
    let nombreEl = document.getElementById('nombre');
    let emailEl = document.getElementById('email');
    let passwordEl = document.getElementById('password');
    let telefonoEl = document.getElementById('telefono');

    function validarNombre() {
        // Valida que el nombre tenga al menos 2 letras
        let regEx = /^[a-zA-ZÀ-ÿ\s]{2,}$/;
        let esValido = regEx.test(nombreEl.value);
        nombreEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    function validarEmail() {
        // Valida formato estándar de email
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
        return esValido;
    }

    function validarTelefono() {
        // Valida exactamente 9 dígitos
        let regEx = /^[0-9]{9}$/;
        let esValido = regEx.test(telefonoEl.value);
        telefonoEl.style.borderColor = esValido ? 'green' : 'red';
        return esValido;
    }

    nombreEl.addEventListener('blur', validarNombre);
    emailEl.addEventListener('blur', validarEmail);
    telefonoEl.addEventListener('blur', validarTelefono);
    passwordEl.addEventListener('blur', validarPassword);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        // Si todas las funciones retornan true, se envía
        if (validarNombre() && validarEmail() && validarPassword() && validarTelefono()) {
            form.submit();
        } else {
            alert("Por favor, corrige los campos en rojo.");
        }
    });
});