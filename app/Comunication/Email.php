<?php

namespace App\Comunication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Email
{
    /**
     * Credenciais de acesso ao SMTP
     */
    // const SECURE = PHPMailer::ENCRYPTION_STARTTLS;
    // const PORT = 587;

    /**
     * Mensagem de erro do envio
     * @var string
     */
    private $error;

    /**
     * Método responsável por retornar a mensagem de erro do envio
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Método responsável por enviar um email
     *
     * @param string $address
     * @param string $subject
     * @param string $body
     * @param string $atachment
     * @return boolean
     */
    public function sendMail($address, $name, $subject, $body, $atachment = '')
    {

        // LIMPAR A MENSAGEM DE ERRO
        $this->error = '';

        //INSTÂNCIA DE PHPMAILER
        $obMail = new PHPMailer(true);
        try {
            //CREDENCIAIS DE ACESSO
            $obMail->isSMTP(true);
            $obMail->Host =  getenv('MAIL_HOST');
            $obMail->SMTPAuth = true;
            $obMail->Username = getenv('MAIL_USER');
            $obMail->Password = getenv('MAIL_PASS');
            $obMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $obMail->Port = getenv('MAIL_PORT');
            $obMail->CharSet = getenv('MAIL_CHARSET');

            //REMETENTE
            $obMail->setFrom(getenv('FROM_EMAIL'), getenv('FROM_NAME'));
            $obMail->addAddress(getenv('TO_EMAIL'), getenv('TO_NAME'));
            $obMail->addReplyTo($address, $name);
            if ($atachment) {
                $obMail->addAttachment($atachment);
            }

            //CONTEÚDO DO E-MAIL
            $obMail->isHTML(true);
            $obMail->Subject = $subject;
            $obMail->Body = $body;

            //ENVIA O E-MAIL
            return $obMail->send();
        } catch (PHPMailerException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}

?>