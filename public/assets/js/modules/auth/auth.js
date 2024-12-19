document.addEventListener('DOMContentLoaded', function() {
    // Slide in auth card
    const authCard = document.querySelector('.auth-card');
    if (authCard) {
        setTimeout(() => {
            authCard.classList.add('slide-in');
        }, 100);
    }

    // Page transition for auth links
    document.querySelectorAll('a[href*="login"], a[href*="register"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            const transition = document.querySelector('.page-transition');
            const pageContent = document.querySelector('.page-content');
            
            // Prevenir scroll durante la transición
            document.body.classList.add('transitioning');
            
            // Iniciar la transición
            transition.classList.add('active');
            pageContent.classList.add('fade-out');
            
            // Esperar a que termine la transición antes de navegar
            setTimeout(() => {
                window.location.href = href;
            }, 500);
        });
    });
});
