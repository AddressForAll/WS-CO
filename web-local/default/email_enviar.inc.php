<?php 
$email = isset($_GET['email']) ? $_GET['email'] : '';
$hash = MD5($email);
$date = date('d/m/y H:i');
echo "\nDispando e-mail de confirmação de assinatura para: $email";
if(empty($email)){
    echo "<script>alert('Parâmetro e-mail não encontrado, verificar requisição.')</script>";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
echo "\n.... Bibliotecas importadas";

require '../vendor/autoload.php';
echo "\n.... Autoload carregado";

try{
$mail = new PHPMailer(true);
}catch (Exception $e){ print_r($e);};

try {
    //Server settings
    $mail->isSMTP();                                             // Send using SMTP
    $mail->Host        = 'localhost';                            // Set the SMTP server to send through
    $mail->SMTPAuth    = true;                                   // Enable SMTP authentication
    $mail->Port        = 25;                                     // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->SMTPSecure  = false;
    $mail->SMTPAutoTLS = false;
    $mail->SMTPAuth    = false;
    $mail->addReplyTo('crebollo@unicamp.br', 'Carlos Rebollo');
    $mail->CharSet = 'UTF-8';

    // From
    $mail->setFrom('noraplay@addressforall.org', 'AddressForAll');
    echo "\n.... Configurações OK";
    // To
    $mail->addAddress($email);     // Add a recipient
    echo "\n.... Destinatários OK";

    // Content
    $mail->isHTML(true);                                    // Set email format to HTML
    $mail->Subject = 'Confirmação de Assinatura - Instituto Address For All';
    $mail->Body    = 
    "Prezado $email<br/> 
    Recebemos seu registro de interesse em assinar nossa newsletter e estamos muito felizes com essa escolha! 
    <br/><br/>
    Para confirmar sua inscrição, por gentileza, clique no link abaixo:
    <br/>
    <a href='http://addressforall.org/default/email_confirmar.inc.php?email=$email&hash=$hash'><h3>Confirmar Assinatura!</h3></a>
    <br/><br/>
    Cordialmente, <br/><br/>Equipe AddressForAll.";
    $mail->send();
    echo "\n.... Great! Message has been sent";

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
