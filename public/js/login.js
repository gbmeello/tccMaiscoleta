$(document).ready(function() {

    $('#btn-login').unbind('click').click(function() {
        authenticate();
    });

});

function authenticate() {

    let data = $('#form-login').serialize();
    let $btnLogin = $('#btn-login');

    $.ajax({
        type: 'POST',
        url: '/auth/login',
        data: data,
        dataType: 'json',
        beforeSend: function() {
            $btnLogin.button('loading');
        },
        complete: function() {
            $btnLogin.button('reset');
        },
        success: function(data) {

            alert('logado !');

        },
        error: function(xhr, response) { // if error occured
            $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
        }
    });
}