<?php
    require_once __DIR__ . '/vendor/autoload.php';
    \App\Common\Environment::loadEnv();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fomulario</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/enter-view"></script>
    <script src="script.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</head>
<body>

    <form id="contato" action="send-email.php" method="POST">
        <h2 class="section__title">Contato:</h2>
        <p class="form__subtitle">Preencha nosso formulário e em breve entraremos em contato com você.</p>

        <div class="form__fields-wrapper">
            <label class="form__label" for="nome">Nome:</label>
            <input class="form__field" id="nome" type="text" name="nome" required></input>
<br>
            <label class="form__label" for="email">E-mail:</label>
            <input class="form__field" id="email" type="email" name="email" required></input>
<br>
            <label class="form__label" for="whatsapp">Whatsapp:</label>
            <input class="form__field" id="whatsapp" type="tel" name="whatsapp" minlength="15" maxlength="15" pattern="\(\d{2}\)\s*\d{5}-\d{4}" required></input>
<br>
            <label class="form__label" for="assunto">Assunto:</label>
            <input class="form__field" list="assuntos" type="text" name="assunto" id="assunto">
                <datalist id="assuntos">
                    <option value="Contato">
                    <option value="Desejo fazer uma visita">
                    <option value="Projetos">
                    <option value="Matrícula">
                    <option value="Informações">
                </datalist>
<br>
            <label class="form__label" for="mensagem">Digite sua mensagem:</label>
            <textarea class="form__field form__field--textarea" id="mensagem" type="text" name="mensagem" required></textarea>


            <div class="g-cap-wrapper">
                <div id="recaptcha" class="g-recaptcha"></div>
                <div class="flex-message">
                    <button id="submit" type="submit" class="button">Enviar<span></span></button>
                    <div id="aviso-box" style="display: none;">
                        <i id="aviso-icon"></i>
                        <span id="aviso-span"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>
</html>