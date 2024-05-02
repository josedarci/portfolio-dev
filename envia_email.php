<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui os arquivos do PHPMailer
require ("PHPMailer-master/src/PHPMailer.php");
require ("PHPMailer-master/src/SMTP.php");
require ("PHPMailer-master/src/Exception.php"); // Certifique-se de incluir esta linha

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fun��o para enviar e-mail
function sendEmail($name, $email, $message)
{
    $mail = new PHPMailer(true);
    try {
        // Configura��es do servidor
        $mail->isSMTP();                                            // Define o uso de SMTP
        $mail->Host = 'smtp.example.com';                           // Especifica o servidor SMTP
        $mail->SMTPAuth = true;                                     // Ativa a autentica��o SMTP
        $mail->Username = 'your-email@example.com';                 // SMTP username
        $mail->Password = 'your-password';                          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Ativa a encripta��o TLS; `PHPMailer::ENCRYPTION_SMTPS` tamb�m � aceito
        $mail->Port = 587;                                           // Porta TCP para conectar, use 465 para `PHPMailer::ENCRYPTION_SMTPS` acima

        // Destinat�rios
        $mail->setFrom('your-email@example.com', 'Mailer');
        $mail->addAddress($email, $name);                           // Adiciona um destinat�rio

        // Conte�do
        $mail->isHTML(true);                                        // Define o formato do e-mail para HTML
        $mail->Subject = 'Nova mensagem de contato';
        $mail->Body = '<b>Mensagem:</b> ' . htmlspecialchars($message);
        $mail->AltBody = 'Mensagem: ' . htmlspecialchars($message);

        $mail->send();
        echo 'Mensagem enviada com sucesso';
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
    }
}

// Verifica se a requisi��o � POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? 'Nome n�o fornecido';
    $email = $_POST['email'] ?? 'Email n�o fornecido';
    $message = $_POST['message'] ?? 'Mensagem n�o fornecida';

    // Chama a fun��o de enviar e-mail
    sendEmail($name, $email, $message);
}
?>