$(function () {
    $('#nav-main #nav-language-handler').change(function () {
        $(this).parents('.dropdown').toggleClass('is-active');
    });

    const logoAnimationCookie = document.cookie.split('; ')
    .find((row) => row.startsWith('logo-animation='))
    ?.split('=')[1];

    if (logoAnimationCookie == 'on' || typeof logoAnimationCookie == 'undefined') {
        $('#header-main-grid .logo').addClass('animated');
    }

    $('#logo-animation-switch-handler').change(function () {
        let isChecked = $(this).is(':checked');
        const d = new Date();
        d.setTime(d.getTime() + (28*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();

        if (isChecked) {
            $('#header-main-grid .logo.animated').removeClass('animated');
            document.cookie = "logo-animation=off; " + expires + "; path=/; secure; samesite=Strict;";
        } else {
            $('#header-main-grid .logo').addClass('animated');
            document.cookie = "logo-animation=on; " + expires + "; path=/; secure; samesite=Strict;";
        }
    });
});