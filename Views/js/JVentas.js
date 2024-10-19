// Datos Ejemplo
const courseData = {
    "Curso de Desarrollo Web": {
        students: [
            { name: "Juan Pérez", date: "12 Feb 2024", progress: "90%", price: "$1,500.00", payment: "Tarjeta" },
            { name: "María López", date: "15 Mar 2024", progress: "80%", price: "$1,200.00", payment: "PayPal" }
        ],
        total: "$25,000.00"
    },
    "Curso de Programación en Python": {
        students: [
            { name: "Carlos Rodríguez", date: "18 Feb 2024", progress: "100%", price: "$1,800.00", payment: "Tarjeta" },
            { name: "Ana Morales", date: "22 Mar 2024", progress: "75%", price: "$1,400.00", payment: "PayPal" }
        ],
        total: "$18,000.00"
    }
};

document.querySelectorAll('.course-row').forEach(row => {
    row.addEventListener('click', function () {
        const courseName = this.getAttribute('data-course');
        const courseDetails = courseData[courseName];
        const studentsBody = document.getElementById('students-body');
        const courseTotal = document.getElementById('course-total');

        // Limpiar los detalles previos
        studentsBody.innerHTML = '';

        // Insertar nuevos detalles
        courseDetails.students.forEach(student => {
            const row = `<tr>
                <td>${student.name}</td>
                <td>${student.date}</td>
                <td>${student.progress}</td>
                <td>${student.price}</td>
                <td>${student.payment}</td>
            </tr>`;
            studentsBody.innerHTML += row;
        });

        // Actualizar el total del curso
        courseTotal.textContent = courseDetails.total;

        // Mostrar la sección de detalles
        document.getElementById('course-details').style.display = 'block';
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var addCourseBtn = document.getElementById('add-course-btn');

    addCourseBtn.addEventListener('click', function (event) {
    
        var isConfirmed = confirm('¿Está seguro de que desea agregar un curso?');

    
        if (!isConfirmed) {
            event.preventDefault(); 
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var addCourseBtn = document.getElementById('course-des');

    addCourseBtn.addEventListener('click', function (event) {
    
        var isConfirmed = confirm('¿Está seguro de que desea deshabilitar el curso seleccionado un curso?');

    
        if (!isConfirmed) {
            event.preventDefault(); 
        }
        var isConfirmed = confirm('Curso Eliminado');
    });
});
