// button close nav movil
$(document).ready(function() {
    $('#cerrarNavbar').click(function() {
        $('#navbarSupportedContent').collapse('hide');
    });
});

/* *--------------------------------------------------------------
# Menu sidebar
--------------------------------------------------------------*/

document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.sidebar-link');
    const sections = document.querySelectorAll('.section');

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const section = this.getAttribute('data-section');
            showSection(section);
            setActiveLink(this);
        });
    });

    function showSection(section) {
        sections.forEach(sec => {
            if (sec.id === section) {
                sec.style.display = 'block';
            } else {
                sec.style.display = 'none';
            }
        });
    }

    function setActiveLink(clickedLink) {
        links.forEach(link => {
            link.classList.remove('active');
        });
        // clickedLink.classList.add('active');
    }

    // Show the "perfil" section by default
    showSection('perfil');
    setActiveLink(document.querySelector('[data-section="perfil"]'));
});

/* *--------------------------------------------------------------
# Change avatar and delete
--------------------------------------------------------------*/

function selectAvatar(avatarUrl) {
    document.getElementById('main_avatar').src = avatarUrl;
    document.getElementById('selected_avatar').value = avatarUrl;
    document.getElementById('form_avatar_change').submit(); // Enviar el formulario al seleccionar un nuevo avatar
    showConfirmationCheck();
}

function showConfirmationCheck() {
    const confirmCheck = document.getElementById('confirm_check');
    confirmCheck.style.display = 'block';

    // // Aplicar la clase de animación
    // confirmCheck.classList.add('drop-fade-out');

    // Ocultar el icono después de la animación
    setTimeout(() => {
        confirmCheck.style.display = 'none';
        // Remover la clase de animación para futuros usos
        confirmCheck.classList.remove('drop-fade-out');
    }, 1000); // Duración de la animación: 1 segundo
}

