document.addEventListener('DOMContentLoaded', function() {
    const topicButtons = document.querySelectorAll('.topic-btn');
    const subtopicsLists = document.querySelectorAll('.subtopics-list');

    // Alternar la visibilidad de la lista de subtemas
    topicButtons.forEach(button => {
        button.addEventListener('click', function() {
            const subtopicsList = this.nextElementSibling;
            const arrow = this.querySelector('.arrow');

            if (subtopicsList.style.display === 'block') {
                subtopicsList.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                subtopicsList.style.display = 'block';
                arrow.style.transform = 'rotate(90deg)';
            }
        });
    });

    // Cargar el video seleccionado en el reproductor de la izquierda
    const subtopicLinks = document.querySelectorAll('.subtopic-link');
    const video = document.getElementById('course-video');
    const totalNiveles = subtopicLinks.length;

    subtopicLinks.forEach((link, index) => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Evita la navegación
            video.src = this.getAttribute('href'); // Actualiza la fuente del video
            video.load(); // Carga el nuevo video
            video.play(); // Reproduce el video automáticamente

            // Al finalizar el video, marcar la casilla de verificación y enviar el progreso
            video.onended = function() {
                const progreso = ((index + 1) / totalNiveles) * 100;
                document.getElementById('progreso').value = progreso;
                document.getElementById('progresoForm').submit();

            };
        });
    });
});

document.querySelector('.resource-header').addEventListener('click', function() {
    const content = document.querySelector('.resource-content');
    const icon = document.querySelector('.toggle-icon');
    
    if (content.style.display === 'block') {
        content.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'block';
        icon.style.transform = 'rotate(90deg)';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.delete-btn');
    const modal = document.getElementById('deleteModal');
    const closeBtn = document.querySelector('.close-btn');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const motivoTextarea = document.getElementById('motivo');
    let comentarioId = null; // Para almacenar el id del comentario a eliminar

    // Abre el modal y almacena el id del comentario al hacer clic en el botón de eliminar
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            comentarioId = this.getAttribute('data-id');
            modal.style.display = 'block';
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    confirmDeleteBtn.addEventListener('click', function() {
        const motivo = motivoTextarea.value.trim();
        if (motivo && comentarioId) {
            // Buscar el formulario correspondiente al comentario que se quiere eliminar
            const form = document.querySelector(`form[data-id="${comentarioId}"]`);
            
            if (form) {
                // Crear el campo oculto con el motivo de eliminación
                const motivoInput = document.createElement('input');
                motivoInput.type = 'hidden';
                motivoInput.name = 'motivo';
                motivoInput.value = motivo;

                // Agregar el input al formulario
                form.appendChild(motivoInput);

                // Enviar el formulario
                form.submit();
                modal.style.display = 'none';
            } else {
                alert('No se encontró el formulario para este comentario.');
            }
        } else {
            alert('Por favor, proporciona un motivo para la eliminación.');
        }
    });
});