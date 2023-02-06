<?php
include 'functions.php';
$errors = [];
$data = [];

if (empty($_POST['name'])) {
    $errors['name'] = 'Name is required.';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;

    $to_email = 'hello@miref.app';
    $subject = 'Welcome to Miref';
    $message = 'Welcome to Miref. <br>'
    . '<p>Dear '.$_POST['name'].', </p>'.

    '<p align="justify">We are excited to welcome you to the Miref community! We appreciate your interest in our app and are thrilled to have you onboard.

    We wanted to take a moment to thank you for your support and to let you know that we are working hard to bring our app to market as soon as possible. We are confident that you will find it to be a valuable tool and we can’t wait to win together. 

    Once the app is launched, we will be sure to notify you and provide you with all the details you need to get started. In the meantime, please don’t hesitate to reach out to us if you have any questions or feedback.

    Thank you again for your interest in Miref and we look forward to connecting with you soon.

    We win together. </p>'.

    '<br><b>Nenka from Miref</b>';
    $headers = 'From: hello@miref.app'        . "\r\n" .
                'Reply-To: hello@miref.app' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                  
          //mail($email,$subject,$message,$headers);
    sendMail($business,'Welcome to Miref',$message,'Miref | Miref Portal', $_POST['email']);

    $data['success'] = true;
    $data['message'] = 'Thank you for your interest. We will get back shortly';
}

echo json_encode($data);