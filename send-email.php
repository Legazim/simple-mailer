<?php

header('Content-Type: application/json; charset=utf-8');
if (empty($_POST)) {
    $data = [
        'success' => false,
        'message' => 'Ocorreu um erro.'
    ];
    echo json_encode($data);
    exit;
};

if (empty($_POST['g-recaptcha-response'])) {
    $data = [
        'success' => false,
        'message' => 'reCAPTCHA inválido.'
    ];
    echo json_encode($data);
    exit;
};

require_once __DIR__ . '/vendor/autoload.php';
\App\Common\Environment::loadEnv();

$response = $_POST['g-recaptcha-response'];
$secret = getenv('RECAPTCHA_SECRET_KEY');
$remoteip = $_SERVER['REMOTE_ADDR'];
$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
$captchaResponse = json_decode(file_get_contents($url), true);

if ($captchaResponse['success'] != true) {
    $data = [
        'success' => false,
        'message' => 'reCAPTCHA inválido.'
    ];
    echo json_encode($data);
    exit;
};

use \App\Comunication\Email;

date_default_timezone_set('America/Sao_Paulo');

$nome = $_POST['nome'];
$email = $_POST['email'];
$whatsapp = $_POST['whatsapp'];
$mensagem = nl2br($_POST['mensagem']);
$assunto = $_POST['assunto'] ?: 'Contato';
$subject = 'Assunto: '.$assunto.' ('.$nome.')';

$body = '<span><b>Nome:</b></span><br><span>'.$nome.'</span>
         <br><br>
         <span><b>E-mail:</b></span><br><span>'.$email.'</span>
         <br><br>
         <span><b>Numero:</b></span><br><span>'.$whatsapp.'</span>
         <br><br>
         <span><b>Assunto:</b></span><br><span>'.$assunto.'</span>
         <br><br><span><b>Mensagem:</b></span><br><span>'.$mensagem.'</span>
         <br><br>
         <span><b>'.date('d/m/Y H:i:s').'</br></span>';

if ($captchaResponse['success'] == false) :
    $data = [
        'success' => false,
        'message' => 'reCAPTCHA inválido.'
    ];
    echo json_encode($data);
    exit;

else :

    $obMail = new Email;
    $sucesso = $obMail->sendMail($email, $nome, $subject, $body);

    if (empty($sucesso)) {
        $data = [
            'success' => false,
            'message' => $obMail->getError(),
        ];
    } else {
        $data = [
            'success' => true,
            'message' => 'Mensagem enviada.'
        ];
    };

    echo json_encode($data);
    exit;
endif;
?>
