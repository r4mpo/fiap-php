$(document).ready(function () {

    let baseUrl = $("meta[name='baseUrl']").attr("content");

    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        let email = $('#email').val().trim();
        let password = $('#password').val().trim();
        let hasError = false;

        // Remove mensagens de erro anteriores
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Validação simples de e-mail
        if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $('#email').addClass('is-invalid')
                .after('<div class="invalid-feedback">Informe um e-mail válido.</div>');
            hasError = true;
        }

        // Validação de senha
        if (password === '') {
            $('#password').addClass('is-invalid')
                .after('<div class="invalid-feedback">Informe sua senha.</div>');
            hasError = true;
        }

        // Se tiver erro, para aqui
        if (hasError) return;

        // Envio via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: {
                email: email,
                password: password
            },
            dataType: 'json',
            success: function (response) {
                console.log(response)
                if (response.code == '111') {
                    window.location.href = baseUrl;
                } else {
                    message('Oops!', response.message ?? 'Erro ao fazer login.', 'error');
                }
            },
            error: function () {
                message('Oops!', 'Ocorreu um erro na requisição. Tente novamente.', 'error');
            }
        });
    });

    var message = function (title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon
        });
    };
});