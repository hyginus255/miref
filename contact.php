<?php
include 'conn.php';
include 'functions.php';
$errors = [];
$data = [];

if (empty($_POST['fname'])) {
    $errors['fname'] = 'Name is required.';
}

if (empty($_POST['lname'])) {
    $errors['lname'] = 'Last Name is required.';
}

if (empty($_POST['message'])) {
    $errors['message'] = 'Message is required.';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';
}

if (empty($errors)) {
    
    $data['success'] = false;
    $data['errors'] = $errors;

    $to_email = 'hello@miref.app';
    $subject = 'Contact to Miref';
    $message = 'Miref Team. <br>'
    . '<p>Name: '.$_POST['fname'].' '.$_POST['lname'].' </p>'.
    '<p>Email: '.$_POST['email']. '</p>' .
    '<p>Phone: '.$_POST['phone'].' </p>' .
    '<p>Message: '.$_POST['message'].' </p>';

    $headers = 'From: hello@miref.app'        . "\r\n" .
                'Reply-To: hello@miref.app' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
    // $query = mysqli_query($conn, "insert into subscribers(fullname,email) values ('$_POST[name]','$_POST[email]')");
    // if($query){
        // mail($_POST['email'],$subject,$message,$headers);
        sendMail('Miref Team','Welcome to Miref',$message,'Miref | Miref Portal', $to_email);
        
        $data['success'] = true;
        $data['message'] = 'Thank you for your interest. An agent will get back to you shortly';
    // }else{
    //     $data['success'] = false;
    //     $data['message'] = 'An Error Occured. Try again later';
    // }
}

echo json_encode($data);