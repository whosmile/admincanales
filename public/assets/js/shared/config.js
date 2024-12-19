const AppConfig = {
    baseUrl: window.location.origin,
    apiUrl: window.location.origin + '/api',
    routes: {
        auth: {
            login: '/login',
            logout: '/logout'
        },
        dashboard: {
            index: '/dashboard'
        }
    }
};

export default AppConfig;
