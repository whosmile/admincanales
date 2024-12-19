document.addEventListener('DOMContentLoaded', function() {
    // Inicializar los enlaces con transición
    initializeTransitionLinks();
});

function initializeTransitionLinks() {
    // Seleccionar todos los enlaces que deberían tener transición
    document.querySelectorAll('a[data-transition]').forEach(link => {
        link.addEventListener('click', handleTransitionClick);
    });
}

function handleTransitionClick(e) {
    e.preventDefault();
    const href = this.getAttribute('href');
    
    // No hacer transición si es la misma página
    if (href === window.location.href) {
        return;
    }

    // Iniciar transición
    startPageTransition(href);
}

function startPageTransition(targetUrl) {
    const transition = document.querySelector('.page-transition');
    const pageContent = document.querySelector('.page-content');
    
    // Prevenir scroll durante la transición
    document.body.classList.add('transitioning');
    
    // Activar elementos de transición
    transition.classList.add('active');
    pageContent.classList.add('fade-out');
    
    // Navegar después de la transición
    setTimeout(() => {
        window.location.href = targetUrl;
    }, 500);
}
