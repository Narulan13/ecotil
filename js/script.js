window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('shadow');
    } else {
        navbar.classList.remove('shadow');
    }
});
document.addEventListener('DOMContentLoaded', (event) => {
    const tooltip = document.querySelector('.card');
    if (tooltip) {
        const tooltipText = tooltip.querySelector('.tooltiptext');
        if (tooltipText) {
            tooltip.addEventListener('click', () => {
                const isVisible = tooltipText.style.visibility === 'visible';
                tooltipText.style.visibility = isVisible ? 'hidden' : 'visible';
                tooltipText.style.opacity = isVisible ? '0' : '1';
            });
        }
    }
});

function toggleMenu() {
    const mobileNav = document.getElementById('mobileNav');
    mobileNav.style.display = mobileNav.style.display === "flex" ? "none" : "flex";
}
const draggables = document.querySelectorAll('.draggable');
const dropzones = document.querySelectorAll('.dropzone');

draggables.forEach(draggable => {
    draggable.addEventListener('dragstart', () => {
        draggable.classList.add('dragging');
    });

    draggable.addEventListener('dragend', () => {
        draggable.classList.remove('dragging');
    });
});
dropzones.forEach(dropzone => {
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault(); 
    });

    dropzone.addEventListener('drop', () => {
        const dragging = document.querySelector('.dragging');
        if (dragging) {
            dropzone.appendChild(dragging);
        }
    });
});

document.getElementById('check').addEventListener('click', () => {
    let score = 0;
    let totalQuestions = dropzones.length;

    dropzones.forEach(dropzone => {
        const draggedItem = dropzone.querySelector('.draggable');
        if (draggedItem) {
            const isCorrect = draggedItem.getAttribute('data-id') === dropzone.getAttribute('data-correct');
            dropzone.classList.remove('correct', 'incorrect');
            if (isCorrect) {
                score++;
                dropzone.classList.add('correct');
            } else {
                dropzone.classList.add('incorrect');
            }
        }
    });

    let testForm = document.getElementById('testForm');
    let currentActionUrl = testForm.action;
    if (!currentActionUrl.includes('&score=')) {
        currentActionUrl += `&score=${score}`;
    } else {
        currentActionUrl = currentActionUrl.replace(/&score=\d+/, `&score=${score}`);
    }

    testForm.action = currentActionUrl;
    console.log("Form action URL with score: ", currentActionUrl);
    testForm.submit();
});
function isMobileDevice() {
    return window.innerWidth <= 768; 
}
if (isMobileDevice()) {
    draggables.forEach(draggable => {
        draggable.addEventListener('click', () => {
            const availableDropzone = Array.from(dropzones).find(dropzone => !dropzone.querySelector('.draggable'));
            if (availableDropzone && draggable) {
                availableDropzone.appendChild(draggable); 
            }
        });
    });
}
