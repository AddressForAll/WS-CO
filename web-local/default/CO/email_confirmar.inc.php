<?php

$email = isset($_GET['email']) ? $_GET['email'] : '';
$hash = isset($_GET['hash']) ? $_GET['hash'] : '';

if (!empty($email) && !empty($hash)){
    if ($hash == MD5($email)){
        $url = 'http://api-test.addressforall.org/_sql/rpc/newsletter_email_upt';
        $data = array('p_email' => $email);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    }
    else header("Location: http://addressforall.org/");
}
else header("Location: http://addressforall.org/");

#echo "<a href='http://addressforall.org/'><h1>Voltar ao site!</h1></a>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Newsletter</title>
    <style>
    body {
         font-family: "Times New Roman", Times, serif !important;
    }
    h1 {
        font-size: 500%;
    }
    .center {
        width: 50%;
        margin: 0 auto;
    }
    .estilo {
        background-color: #e9e9e9;
        border-radius: 10px;
        margin: 1em;
        padding: 1em;
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="center">
        <div class="estilo">
        <h1>Obrigado!</h1>
        <p>Deu tudo certo com a sua confirmação, <?=$email?>.
        <p>Equipe Address For All</p>
        <a href="http://addressforall.org/"><img src="/resources/img/address_for_all-01.png" heigth="200" width="200"></a>
        </div>
    </div>
</body>
</html>