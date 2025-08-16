$(document).ready(function () {
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();

        let email = $("#email").val().trim();
        let password = $("#password").val().trim();
        let hasError = false;

        // Remove mensagens de erro anteriores
        $(".is-invalid").removeClass("is-invalid");
        $(".invalid-feedback").remove();

        // Validação simples de e-mail
        if (email === "" || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            $("#email").addClass("is-invalid")
                .after('<div class="invalid-feedback">Informe um e-mail válido.</div>');
            hasError = true;
        }

        // Validação de senha
        if (password === "") {
            $("#password").addClass("is-invalid")
                .after('<div class="invalid-feedback">Informe sua senha.</div>');
            hasError = true;
        }

        // Se tiver erro, para aqui
        if (hasError) return;

        // Envio via AJAX
        $.ajax({
            url: $(this).attr("action"),
            method: "POST",
            data: {
                email: email,
                password: password
            },
            dataType: "json",
            success: function (response) {
                if (response.cod == '111') {
                    alert("Login realizado com sucesso!");
                    window.location.href = response.redirect ?? "<?php echo BASE_URL ?>";
                } else {
                    alert(response.message ?? "Erro ao fazer login.");
                }
            },
            error: function () {
                alert("Ocorreu um erro na requisição. Tente novamente.");
            }
        });
    });
});