$(document).ready(function () {

    let baseUrl = $("meta[name='baseUrl']").attr("content");

    $('#genericForm').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let valid = true;

        // Limpa feedback anterior
        form.find('.invalid-feedback').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        form.find('input, textarea').each(function () {
            let input = $(this);
            let feedback = input.siblings('.invalid-feedback');
            let val = input.val().trim();

            // Campo obrigatório
            if (input.prop('required') && val === '') {
                feedback.text('Campo obrigatório.');
                input.addClass('is-invalid');
                valid = false;
                return true; // continue no each
            }

            // Validação minlength
            let min = input.data('minlength');
            if (min && val.length < parseInt(min)) {
                feedback.text(`Mínimo ${min} caracteres.`);
                input.addClass('is-invalid');
                valid = false;
                return true;
            }

            // Validação maxlength
            let max = input.data('maxlength');
            if (max && val.length > parseInt(max)) {
                feedback.text(`Máximo ${max} caracteres.`);
                input.addClass('is-invalid');
                valid = false;
            }
        });

        if (valid) {
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.code === '111'){
                        message('Sucesso!', response.message ?? 'Operação realizada com sucesso.', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        message('Oops!', response.message ?? 'Houve um erro ao realizar a operação.', 'error');
                    }
                },
                error: function () {
                    message('Oops!', 'Ocorreu um erro na requisição. Tente novamente.', 'error');
                }
            });
        }
    });

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

    $('#searchClassForm').on('submit', function (e) {
        e.preventDefault();


        let class_id = $('#classSelect').val().trim();
        let hasError = false;

        // Remove mensagens de erro anteriores
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Validação simples da turma
        if (class_id === '' || class_id == 0) {
            $('#classSelect').addClass('is-invalid')
                .after('<div class="invalid-feedback">Informe uma turma válida.</div>');
            hasError = true;
        }

        // Se tiver erro, para aqui
        if (hasError) return;

        let url = $(this).attr('action') + '/' + class_id;
        window.location.href = url;
    });

    $('.delete-data-open-modal').on('click', function () {
        let dataId = $(this).data('id');
        let dataName = $(this).data('name');
        let deleteUrl = $(this).data('delete-url');
        let dataMessage = `Você realmente deseja <strong>excluir a informação de ${dataName}</strong> do sistema? Esta ação não poderá ser desfeita.`

        // Cria o modal dinamicamente
        let modalHtml = modalDelete(dataId, dataMessage, deleteUrl);
        console.log(modalDelete);
        // Remove qualquer modal anterior
        $('#modalContainer').html(modalHtml);

        // Abre o modal usando Bootstrap 5
        const modal = new bootstrap.Modal(document.getElementById(`deleteDataModal${dataId}`));
        modal.show();

        // Evento para o botão "Excluir"
        $('.confirmDeleteData').on('click', function () {
            const url = $(this).data('url');
            $.ajax({
                url: url,
                method: 'DELETE',
                dataType: 'json',
                success: function (response) {
                    if (response.code === '111') {
                        message('Sucesso!', response.message ?? 'Operação realizada com sucesso.', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        message('Oops!', response.message ?? 'Houve um erro ao realizar a operação.', 'error');
                    }
                },
                error: function () {
                    message('Oops!', 'Ocorreu um erro na requisição. Tente novamente.', 'error');
                }
            });
            modal.hide();
        });
    });




    var modalDelete = function (id, message, deleteUrl) {
        return `
        <div class="modal fade" id="deleteDataModal${id}" tabindex="-1" aria-labelledby="deleteDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content border-danger">
        
                <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title" id="deleteDataLabel">
                    <i class="ri-alert-line me-2"></i> Confirmação de Exclusão
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
        
                <div class="modal-body">
                  <p class="mb-0">
                    <i class="ri-information-line me-1"></i>
                        ${message}
                  </p>
                </div>
        
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Cancelar
                  </button>
                  <button type="button" class="btn btn-danger confirmDeleteData" data-url="${deleteUrl}">
                    <i class="ri-delete-bin-6-line me-1"></i> Excluir
                  </button>
                </div>
              </div>
            </div>
        </div>
        `
    };

    var message = function (title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon
        });
    };
});