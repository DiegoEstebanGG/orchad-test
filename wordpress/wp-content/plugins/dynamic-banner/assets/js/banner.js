jQuery(document).ready(function($) {
    var root = $('body').data('root');
    function actualizarBanner(root) {
        var banner = $('.banner');
        if (root === 'Root A') {
            banner.css('background-image', 'url("https://get.wallhere.com/photo/Batman-1989-movies-film-stills-Moon-Batwing-aircraft-clouds-sky-night-2235710.jpg")');
        } else if (root === 'Root B') {
            banner.css('background-image', 'url("https://get.wallhere.com/photo/1920x1080-px-red-sign-Superman-1295725.jpg")');
        }
    }

    var rootActual = $('body').data('root');
    actualizarBanner(rootActual);
});
