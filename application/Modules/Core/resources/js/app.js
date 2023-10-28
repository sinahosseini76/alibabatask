require('./bootstrap');


changeTheme = function (theme) {
    document.getElementById('theme').setAttribute('href', theme);
    localStorage.setItem('theme', theme);
}
