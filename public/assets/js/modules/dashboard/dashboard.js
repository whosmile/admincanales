document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const sidebarToggle = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay');
    const body = document.body;
    const content = document.getElementById('content');

    // Función para alternar el sidebar
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        
        // Solo mostrar el overlay en móviles
        if (window.innerWidth <= 768) {
            overlay.classList.toggle('active');
        }
    }

    // Event listeners
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebar();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        });
    }

    // Manejar el tema claro/oscuro
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');
    
    function toggleTheme(e) {
        if (e) e.preventDefault(); // Prevenir cualquier comportamiento por defecto
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
    }

    // Establecer el tema inicial
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    themeIcon.className = savedTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';

    themeToggle.addEventListener('click', toggleTheme);

    // Manejar el responsive en dispositivos móviles
    function handleResize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            body.classList.add('sidebar-collapsed');
            overlay.classList.remove('active');
        } else {
            if (!body.classList.contains('sidebar-collapsed')) {
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
            }
            overlay.classList.remove('active');
        }
    }

    // Escuchar cambios en el tamaño de la ventana
    window.addEventListener('resize', handleResize);
    
    // Ejecutar al cargar la página
    handleResize();

    // Manejar los submenús
    const submenuToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            const icon = this.querySelector('.fa-chevron-down');
            if (icon) {
                icon.style.transform = this.getAttribute('aria-expanded') === 'true' 
                    ? 'rotate(0deg)' 
                    : 'rotate(180deg)';
            }
        });
    });

    // Control de sesión y navegación
    let activityTimeout;
    const INACTIVE_TIMEOUT = 30 * 60 * 1000; // 30 minutos en milisegundos

    function resetActivityTimer() {
        clearTimeout(activityTimeout);
        activityTimeout = setTimeout(logout, INACTIVE_TIMEOUT);
    }

    function logout() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => {
            window.location.href = '/login';
        });
    }

    // Eventos para resetear el timer de inactividad
    ['mousemove', 'keypress', 'click', 'touchstart', 'scroll'].forEach(event => {
        document.addEventListener(event, resetActivityTimer);
    });

    // Control de navegación
    window.addEventListener('popstate', function(e) {
        e.preventDefault();
        logout();
    });

    // Prevenir el botón de retroceso
    window.addEventListener('load', function() {
        window.history.pushState({ page: 1 }, "", "");
    });

    // Interceptar clicks en enlaces internos
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && link.href.startsWith(window.location.origin)) {
            resetActivityTimer();
        }
    });

    // Iniciar el timer de actividad
    resetActivityTimer();
});
