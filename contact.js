
function sendContactForm() {
    var formData = {
        name: $('#name').val(),
        email: $('#email').val(),
        message: $('#message').val()
    };

    $.ajax({
        type: 'POST',
        url: 'envia_email.php',
        data: formData,
        success: function (response) {
            alert('Mensagem enviada com sucesso!');
            $('#contactForm').trigger("reset");
        },
        error: function () {
            alert('Erro ao enviar mensagem.');
        }
    });
}
