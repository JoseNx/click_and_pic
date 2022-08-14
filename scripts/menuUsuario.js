/*Este archivo nos para controlar el menu lateral*/
$(document).ready(function () {
/*Menu vertical permanece oculto*/
    $('#menuVertical').hide();

    /*Se oculta el icono y sale el menu de usuario*/
    $('#usuarioPaginaPrincipal').click(function () {
        $('#usuarioPaginaPrincipal').hide();
        $('#menuVertical').show('slow');

    });

    /* Se pulsa la x y el menu de usuario desaparece*/
    $('#cerrar_menu').click(function () {
        $('#menuVertical').hide('slow');
        $('#usuarioPaginaPrincipal').show();

    });

});