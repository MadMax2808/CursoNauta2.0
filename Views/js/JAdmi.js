// Función para mostrar el contenido de la sección seleccionada
function showContent(contentId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.right-pane .section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Remover la clase 'active' de todos los botones
    const buttons = document.querySelectorAll('.left-pane button');
    buttons.forEach(button => {
        button.classList.remove('active');
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(contentId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }

    // Marcar el botón seleccionado como 'active'
    const activeButton = document.querySelector(`.left-pane button[onclick="showContent('${contentId}')"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Mostrar la sección de 'usuarios' por defecto
document.addEventListener('DOMContentLoaded', () => {
    showContent('usuarios');
});

function showContent(contentId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.right-pane .section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Remover la clase 'active' de todos los botones
    const buttons = document.querySelectorAll('.left-pane button');
    buttons.forEach(button => {
        button.classList.remove('active');
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(contentId);
    if (selectedSection) {
        selectedSection.style.display = 'block';
    }

    // Marcar el botón seleccionado como 'active'
    const activeButton = document.querySelector(`.left-pane button[onclick="showContent('${contentId}')"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }

    // Ocultar formulario de agregar categoría si se cambia de sección
    if (contentId !== 'categorias') {
        toggleCategoryForm(false);
    }
}

function toggleCategoryForm(show) {
    const form = document.getElementById('add-category-form');
    form.style.display = show ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    showContent('usuarios');
});

document.getElementById('category-form').addEventListener('submit', function(event) {
    const title = document.getElementById('category-title').value;
    const description = document.getElementById('category-description').value;

    let errorMessages = [];

    // Validaciones solo si los campos no están vacíos
    if (title.trim() === '') {
        errorMessages.push('El título no puede estar vacío.');
    }

    if (description.trim() === '') {
        errorMessages.push('La descripción no puede estar vacía.');
    }

    // Mostrar mensajes de error
    if (errorMessages.length > 0) {
        event.preventDefault(); 
        errorMessages.forEach(function(message) {
            alert(message);
        });
    }
});

function confirmarAccion() {
    return confirm("¿Está seguro de que desea realizar esta acción?");
}





