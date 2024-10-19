// Función para generar los campos de los niveles y subtemas dinámicamente
function generateLevelFields() {
    const levels = document.getElementById("levels").value;
    const levelContainer = document.getElementById("level-container");
    levelContainer.innerHTML = ''; // Limpiar contenedor de niveles previos

    for (let i = 1; i <= levels; i++) {
        const levelDiv = document.createElement("div");
        levelDiv.classList.add("mb-4", "p-4", "border", "border-gray-300", "rounded-md", "bg-gray-50");

        // Título del nivel
        const levelTitle = document.createElement("h3");
        levelTitle.classList.add("text-lg", "font-bold", "text-purple-700", "mb-2");
        levelTitle.innerText = `Nivel ${i}`;
        levelDiv.appendChild(levelTitle);

        // Campo para el título del nivel
        const titleLabel = document.createElement("label");
        titleLabel.setAttribute("for", `level-title-${i}`);
        titleLabel.classList.add("block", "text-sm", "font-medium", "text-gray-700");
        titleLabel.innerText = `Título del Nivel ${i}:`;
        levelDiv.appendChild(titleLabel);

        const titleInput = document.createElement("input");
        titleInput.type = "text";
        titleInput.name = `level_title_${i}`;
        titleInput.id = `level-title-${i}`;
        titleInput.required = true;
        titleInput.classList.add("w-full", "mt-2", "p-2", "border", "border-gray-300", "rounded-md");
        levelDiv.appendChild(titleInput);

        // Subtemas y videos
        const subtopicContainer = document.createElement("div");
        subtopicContainer.classList.add("mt-4");
        subtopicContainer.id = `subtopic-container-${i}`;

        const addSubtopicButton = document.createElement("button");
        addSubtopicButton.type = "button";
        addSubtopicButton.innerText = `Agregar subtema y video al Nivel ${i}`;
        addSubtopicButton.classList.add("bg-purple-700", "text-white", "px-4", "py-2", "rounded-md", "mt-2", "hover:bg-purple-800");
        addSubtopicButton.onclick = function() {
            addSubtopic(i);
        };

        levelDiv.appendChild(subtopicContainer);
        levelDiv.appendChild(addSubtopicButton);

        // Añadir el div de nivel al contenedor
        levelContainer.appendChild(levelDiv);
    }
}

// Función para añadir subtema y video a cada nivel
function addSubtopic(level) {
    const subtopicContainer = document.getElementById(`subtopic-container-${level}`);

    const subtopicDiv = document.createElement("div");
    subtopicDiv.classList.add("mb-4", "p-4", "border", "border-gray-200", "rounded-md", "bg-white");

    // Campo para el subtema
    const subtopicLabel = document.createElement("label");
    subtopicLabel.setAttribute("for", `subtopic-${level}`);
    subtopicLabel.classList.add("block", "text-sm", "font-medium", "text-gray-700");
    subtopicLabel.innerText = `Subtema del Nivel ${level}:`;
    subtopicDiv.appendChild(subtopicLabel);

    const subtopicInput = document.createElement("input");
    subtopicInput.type = "text";
    subtopicInput.name = `subtopic_${level}[]`;
    subtopicInput.id = `subtopic-${level}`;
    subtopicInput.required = true;
    subtopicInput.classList.add("w-full", "mt-2", "p-2", "border", "border-gray-300", "rounded-md");
    subtopicDiv.appendChild(subtopicInput);

    // Campo para el video
    const videoLabel = document.createElement("label");
    videoLabel.setAttribute("for", `video-${level}`);
    videoLabel.classList.add("block", "text-sm", "font-medium", "text-gray-700", "mt-4");
    videoLabel.innerText = `Enlace al video del Subtema:`;
    subtopicDiv.appendChild(videoLabel);

    const videoInput = document.createElement("input");
    videoInput.type = "url";
    videoInput.name = `video_${level}[]`;
    videoInput.id = `video-${level}`;
    videoInput.required = true;
    videoInput.classList.add("w-full", "mt-2", "p-2", "border", "border-gray-300", "rounded-md");
    subtopicDiv.appendChild(videoInput);

    subtopicContainer.appendChild(subtopicDiv);
}

document.getElementById('course-form').addEventListener('submit', function(event) {
    const courseImage = document.getElementById('course-image').files.length;
    const title = document.getElementById('course-title').value.trim();
    const description = document.getElementById('course-description').value.trim();
    const levels = document.getElementById('levels').value;
    const coursePrice = document.getElementById('course-price').value;
    const attachments = document.getElementById('attachments').files.length;

    let errorMessages = [];

    // Validaciones
    if (courseImage === 0) {
        errorMessages.push('Debes cargar una imagen del curso.');
    }

    if (title === '') {
        errorMessages.push('El título del curso no puede estar vacío.');
    }

    if (description === '') {
        errorMessages.push('La descripción del curso no puede estar vacía.');
    }

    if (levels < 1) {
        errorMessages.push('La cantidad de niveles debe ser al menos 1.');
    }

    if (coursePrice <= 0) {
        errorMessages.push('El costo del curso debe ser un valor positivo.');
    }

    if (attachments === 0) {
        errorMessages.push('Debes adjuntar al menos un archivo de recursos.');
    }

    // Mostrar mensajes de error
    if (errorMessages.length > 0) {
        event.preventDefault(); 
        errorMessages.forEach(function(message) {
            alert(message);
        });
    }
});
