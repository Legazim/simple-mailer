// não consegui fazer com jQuery

const tel = document.getElementById('whatsapp')

tel.addEventListener('keypress', (e) => mascaraTelefone(e.target.value)); // Dispara quando digitado no campo
tel.addEventListener('change', (e) => mascaraTelefone(e.target.value)); // Dispara quando autocompletado o campo

const mascaraTelefone = (valor) => {
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/^(\d{2})(\d)/g, "($1) $2");
    valor = valor.replace(/(\d)(\d{4})$/, "$1-$2");
    tel.value = valor // Insere o valor no campo
};

// Ajax para formulário de contato
$('#contato').on('submit', function (event) {
    event.preventDefault();
    let formfields = new FormData($('#contato')[0]);
    $.ajax({
        type: 'POST',
        url: 'send-email.php',
        data: formfields,
        processData: false,
        contentType: false,
        beforeSend: () => {
            // Aviso 'Enviando'
            $('#aviso-box').css('background-color', '#e0ecf9'); // azul
            $('#aviso-span').html('enviando');
            $('#aviso-box, #aviso-span').show();
            $('#aviso-icon').attr('class', 'fas fa-circle-notch spin');
            // Block formulario
            $('#submit, .form__label, .form__field').addClass('block');
            $('#submit, .form__field').prop('disabled', true);
        },
        success: function (response) {
            // Unblock e reset formulario
            $('#submit, .form__label, .form__field').removeClass('block');
            $('#submit, .form__field').prop('disabled', false);
            grecaptcha.reset();
            // Set timeout para remover aviso
            setTimeout(() => {
                $('#aviso-span').hide(100);
                $('#aviso-box').hide(300);
            }, 5000);
            if (response.success) {
                // Aviso sucesso
                $('#contato')[0].reset();
                $('#aviso-span').html(response.message);
                $('#aviso-icon').attr('class', 'fas fa-check-circle sent');
                $('#aviso-box').css('background-color', '#d4ffdc'); // verde
            } else {
                // avisos de erro
                $('#aviso-icon').attr('class', 'fas fa-exclamation-triangle error');
                $('#aviso-box').css('background-color', '#ffbcbf'); // red
                if (response.message.includes('Invalid address:')) {
                    $('#aviso-span').html('E-mail inválido.');
                } else if (response.message == 'reCAPTCHA inválido.') {
                    $('#aviso-span').html(response.message);
                } else {
                    $('#aviso-span').html('Ocorreu um erro.<br>Tente novamente');
                };
            };
        }
    });
});

var onloadCallback = function() {
    const reCaptcha = document.getElementById('recaptcha')
    grecaptcha.render(
        reCaptcha,{
            sitekey: "6LcmFokfAAAAACnKvLWb-ig61GUa6mJgXdtW0yOK",
            theme: "light"
        }
    );
};