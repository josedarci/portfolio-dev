<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $nome = $data->nome;
    $email = $data->email;
    $assunto = $data->assunto;
    $mensagem = $data->mensagem;

    // Instância do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@dharacastilho.com';
        $mail->Password = 'Dh@riTch*#8';
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587; 

        // Configurações adicionais
        $mail->setFrom('contato@dharacastilho.com', 'Dhara Castilho');
        $mail->addReplyTo('contato@dharacastilho.com', 'Dhara Castilho');
        $mail->addAddress('contato@dharacastilho.com', 'Dhara Castilho'); // Endereço de e-mail do destinatário
        $mail->Subject = $assunto;
        $mail->Body = "Nome: $nome\nEmail: $email\n\nMensagem:\n$mensagem";

        // Envia o e-mail
        $mail->send();

        http_response_code(200);
        echo json_encode(array("message" => "Email enviado com sucesso!"));
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Erro ao enviar email: " . $mail->ErrorInfo));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido"));
}
?>
