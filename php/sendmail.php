<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exeption.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('uk', 'phpmailer/language/');
    $mail->IsHTML(true);

    // Від кого
    $mail->setForm('info@fls.guru', 'Сайт');
    // Кому
    $mail->addAddress('merlinovandrej@gmail.com');
    // Тема
    $mail->Subject = 'Здоров!';

    // Рука
    $hand = "Права";
    if($_POST['hand']=="left"){
        $hand = "Ліва";
    }

    // Тіло листа
    $body = '<h1>Зустрічайте листа!</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Ім`я:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['hand']))){
        $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
    }
    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Текст:</strong> '.$_POST['message'].'</p>';
    }

    // Файл
    if(!empty($_FILES['image']['tmp_name'])) {
        $filePath = __DIR__."/files/".$_FILES['image']['name'];
        if(copy($_FILES['image']['tmp_name'],$filePath)) {
            $fileAttach = $filePath;
            $body.='<p><strong>Фото в додатку</strong>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    // Відправляєм
    if(!$mail->send()){
        $message ="Помилка!";
    } else {
        $message = 'Данні відправлені!';
    }

    $response = ['message' => $message];

    header('Content-Type: application/json');
    echo json_encode($response);
?>
