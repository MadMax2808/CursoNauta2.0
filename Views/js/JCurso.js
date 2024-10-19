document.addEventListener('DOMContentLoaded', function() {
    const topicButtons = document.querySelectorAll('.topic-btn');
    const subtopicsLists = document.querySelectorAll('.subtopics-list');

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

    const subtopicLinks = document.querySelectorAll('.subtopic-link');
    const video = document.getElementById('course-video');

    subtopicLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            video.src = this.getAttribute('href');
            video.load();
            video.play();
            this.previousElementSibling.checked = true; // Marca la casilla de verificación
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
    
    const links = document.querySelectorAll('.subtopic-link');

    links.forEach(link => {
     
        link.addEventListener('click', function(event) {
            event.preventDefault();
       
            const linkId = this.parentElement.getAttribute('for');
      
            const checkboxId = linkId ? linkId : '';
       
            const checkbox = document.getElementById(checkboxId);

            if (checkbox) {
                checkbox.checked = true;
            }

        });
    });

});
