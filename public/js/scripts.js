$(document).ready(function () {
    // Open Left
    const openMenu = document.querySelector('.menu_icon');
    const closeMenu = document.querySelector('.close-menu-btn');
    const leftMenu = document.querySelector('#left_menu');
    const bodyOverlay = document.querySelector('.body_overlay');
    const body = document.querySelector('.tilton_body');

    openMenu.addEventListener('click', (event) => {
        event.preventDefault();
        leftMenu.classList.add('left');
        bodyOverlay.style.display = "block";
        body.style.overflow = "hidden"
    });
    closeMenu.addEventListener('click', (event) => {
        event.preventDefault();
        leftMenu.classList.remove('left');
        bodyOverlay.style.display = "none";
        body.style.overflow = "auto"
    })
})
