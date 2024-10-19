document.getElementById('edit-btn').addEventListener('click', function() {
    var form = document.getElementById('profile-form');
    var isEditing = form.classList.toggle('editing');
    var inputs = form.querySelectorAll('input, select');
    var button = form.querySelector('button[type="submit"]');
    var photoInput = document.getElementById('photo');

    inputs.forEach(input => input.disabled = !isEditing);
    button.style.display = isEditing ? 'block' : 'none';
    this.textContent = isEditing ? 'Cancelar' : 'Editar';

    photoInput.style.display = isEditing ? 'block' : 'none';
});

document.getElementById('profile-form').addEventListener('submit', function(event) {
    const nombre = document.getElementById('nombre').value;
    const usuario = document.getElementById('usuario').value;
    const correo = document.getElementById('correo').value;
    const contrasena = document.getElementById('contrasena').value;
    const fechaNacimiento = document.getElementById('fecha_nacimiento').value;

    let errorMessages = [];

    // Validaciones solo si los campos no están vacíos
    if (nombre.trim() === '') {
        errorMessages.push('El nombre completo no puede estar vacío.');
    } else if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        errorMessages.push('El nombre completo solo debe contener letras.');
    }

    if (usuario.trim() === '') {
        errorMessages.push('El nombre de usuario no puede estar vacío.');
    } else if (/\s/.test(usuario)) {
        errorMessages.push('El nombre de usuario no puede contener espacios en blanco.');
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (correo.trim() === '') {
        errorMessages.push('El correo electrónico no puede estar vacío.');
    } else if (!emailRegex.test(correo)) {
        errorMessages.push('Por favor, introduce un correo electrónico válido.');
    }

    if (contrasena.trim() === '') {
        errorMessages.push('La contraseña no puede estar vacía.');
    } else {
        if (contrasena.length < 8) {
            errorMessages.push('La contraseña debe tener al menos 8 caracteres.');
        }
        if (!/[A-Z]/.test(contrasena)) {
            errorMessages.push('La contraseña debe contener al menos una letra mayúscula.');
        }
        if (!/[0-9]/.test(contrasena)) {
            errorMessages.push('La contraseña debe contener al menos un número.');
        }
        if (!/[!@#$%^&*]/.test(contrasena)) {
            errorMessages.push('La contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*).');
        }
    }

    // Validación de la fecha de nacimiento
    if (fechaNacimiento.trim() === '') {
        errorMessages.push('La fecha de nacimiento no puede estar vacía.');
    } else {
        var today = new Date();
        var todayFormatted = today.toISOString().split('T')[0];
        if (fechaNacimiento >= todayFormatted) {
            errorMessages.push('La fecha de nacimiento no puede ser hoy ni una fecha futura.');
        }
    }

    // Mostrar mensajes de error
    if (errorMessages.length > 0) {
        event.preventDefault(); 
        errorMessages.forEach(function(message) {
            alert(message);
        });
    }
});
