$(document).ready(function () {

    let baseUrl = $("meta[name='baseUrl']").attr("content");

    $('.cpf').on('input', function () {
        // Remove tudo que não é número
        let value = $(this).val().replace(/\D/g, '');

        // Limita a 11 dígitos
        value = value.substr(0, 11);

        // Aplica a máscara de CPF
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

        $(this).val(value);
    });

    $('#genericForm').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let valid = true;

        // Limpa feedback anterior
        form.find('.invalid-feedback').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        form.find('input, textarea, email, password').each(function () {
            let input = $(this);
            let feedback = input.siblings('.invalid-feedback');
            let val = input.val().trim();
            let type = input.attr('type');

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
                return true;
            }

            // valida CPF
            if (type == 'text' && input.hasClass('cpf') && val) {
                if (!isValidCpf(val)) {
                    isValid = false;
                    input.addClass('is-invalid');
                    feedback.text('Informe um CPF válido.');
                    valid = false;
                    return true;
                }
            }

            // valida email
            if (type == 'email' && val) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(val)) {
                    isValid = false;
                    input.addClass('is-invalid');
                    feedback.text('Informe um e-mail válido.');
                    valid = false;
                    return true;
                }
            }

            // valida senha forte
            if (type == 'password' && val) {
                const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
                if (!strongPassword.test(val)) {
                    isValid = false;
                    input.addClass('is-invalid');
                    feedback.text('A senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos.');
                    valid = false;
                    return true;
                }
            }

        });

        if (valid) {
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.code === '111') {
                        message('Sucesso!', response.message ?? 'Operação realizada com sucesso.', 'success');
                        setTimeout(() => {
                            window.location.href = response.redirect;
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


    var isValidCpf = function (cpf) {
        cpf = cpf.replace(/\D/g, ''); // remove tudo que não for número
        if (cpf.length !== 11) return false;

        // Checa se todos os números são iguais (CPF inválido)
        if (/^(\d)\1{10}$/.test(cpf)) return false;

        // Valida primeiro dígito verificador
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let firstCheck = (sum * 10) % 11;
        if (firstCheck === 10) firstCheck = 0;
        if (firstCheck !== parseInt(cpf.charAt(9))) return false;

        // Valida segundo dígito verificador
        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        let secondCheck = (sum * 10) % 11;
        if (secondCheck === 10) secondCheck = 0;
        if (secondCheck !== parseInt(cpf.charAt(10))) return false;

        return true;
    };

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