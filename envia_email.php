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

// Função para enviar e-mail
function sendEmail($name, $email, $message)
{
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor
        $mail->isSMTP();                                            // Define o uso de SMTP
        $mail->Host = 'smtp.example.com';                           // Especifica o servidor SMTP
        $mail->SMTPAuth = true;                                     // Ativa a autenticação SMTP
        $mail->Username = 'your-email@example.com';                 // SMTP username
        $mail->Password = 'your-password';                          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Ativa a encriptação TLS; `PHPMailer::ENCRYPTION_SMTPS` também é aceito
        $mail->Port = 587;                                           // Porta TCP para conectar, use 465 para `PHPMailer::ENCRYPTION_SMTPS` acima

        // Destinatários
        $mail->setFrom('your-email@example.com', 'Mailer');
        $mail->addAddress($email, $name);                           // Adiciona um destinatário

        // Conteúdo
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

// Verifica se a requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? 'Nome não fornecido';
    $email = $_POST['email'] ?? 'Email não fornecido';
    $message = $_POST['message'] ?? 'Mensagem não fornecida';

    // Chama a função de enviar e-mail
    sendEmail($name, $email, $message);
}
?>