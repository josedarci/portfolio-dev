<?php
use PHPMailer\PHPMailer\PHPMailer;
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
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@dharacastilho.com';
        $mail->Password = 'Dh@riTch*#8';

        // Configurações adicionais
        $mail->setFrom('contato@dharacastilho.com', 'Dhara Castilho');
        $mail->addAddress('contato@dharacastilho.com', 'Dhara Castilho'); // Endereço de e-mail do destinatário
        $mail->Subject = 'PHPMailer contact form';
        $mail->isHTML(false);
        $mail->Body = "Nome: $nome\nEmail: $email\n\nAssunto: $assunto\n\nMensagem:\n$mensagem";

        // Envia o e-mail
        if ($mail->send()) {
            http_response_code(200);
            echo json_encode(array("message" => "Email enviado com sucesso!"));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Erro ao enviar email: " . $mail->ErrorInfo));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Erro ao enviar email: " . $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido"));
}
?>
