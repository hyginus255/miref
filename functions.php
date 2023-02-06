<?php
// ini_set('display_startup_errors',1);
// ini_set('display_errors',1);
// error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

include 'resize_class.php';

function redirect($url) {
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}


// function sendMail($fullname, $subject, $mail_body, $client, $email, $ccArray=array()){
//     try {

//         $mail = new PHPMailer(true);
//         //Server settings
//         $mail->IsSMTP();                // Sets up a SMTP connection 
//         $mail->SMTPDebug = 3;
//         $mail->CharSet = 'UTF-8';                                           //Send using SMTP
//         // $mail->Host       = 'smtp.gmail.com';
//         $mail->Host = gethostbyname('smtp.gmail.com');                     //Set the SMTP server to send through
//         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//         $mail->Username   = 'NSBPPProcurement@gmail.com';                     //SMTP username
//         $mail->Password   = 'NSBPPProcurement1@';                     //SMTP password
//         $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
//         $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
//         //Recipients
//         $mail->setFrom('NSBPPProcurement@gmail.com', 'NSBPP | eProcurement Portal');
//         $mail->addAddress($email, $fullname);     //Add a recipient
//         $mail->addReplyTo('NSBPPProcurement@gmail.com', $client);
    
//         //Content
//         $mail->isHTML(true);                                  //Set email format to HTML
//         $mail->Subject = $subject;
//         $mail->Body    = general_mailtemplate($client,$fullname,$mail_body);
//         $mail->AltBody = $mail_body;

//         $mail->SMTPOptions = array(
//             'ssl' => array(
//                 'verify_peer' => false,
//                 'verify_peer_name' => false,
//                 'allow_self_signed' => true
//             )
//         );

//         if($mail->send()){

//             //unset($mail);
//             return true;
//         }else{
//             echo $mail->ErrorInfo;
//             error_log($mail->ErrorInfo, 0);
//             return json_encode(array("response"=>$mail->ErrorInfo));
//         }

//     } catch (Exception $e) {
//         error_log($mail->ErrorInfo, 0);
//         $response = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//         return $response;
//     }
// }

function sendMail($fullname, $subject, $mail_body, $client, $email, $ccArray=array()){
    try {

        $mail = new PHPMailer(true);
        //Server settings
        $mail->IsSMTP();                // Sets up a SMTP connection 
        //$mail->SMTPDebug = 3;
        $mail->CharSet = 'UTF-8';                                           //Send using SMTP
        //$mail->Host       = 'smtp.gmail.com';
        //$mail->Host = gethostbyname('smtp.gmail.com');                     //Set the SMTP server to send through
        $mail->Host = 'localhost';
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false; 
        $mail->Port = 25;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('hello@miref.app', 'Miref | Miref Portal');
        $mail->addAddress($email, $fullname);     //Add a recipient
        $mail->addReplyTo('wilsonabah@gmail.com', $client);
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = general_mailtemplate($client,$fullname,$mail_body);
        $mail->AltBody = $mail_body;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        if($mail->send()){
            //sendsms($phone, $mail_body);
            //unset($mail);
            return true;
        }else{
            echo $mail->ErrorInfo;
            error_log($mail->ErrorInfo, 0);
            return json_encode(array("response"=>$mail->ErrorInfo));
        }

    } catch (Exception $e) {
        error_log($mail->ErrorInfo, 0);
        $response = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return $response;
    }
}

function sendsms($phone, $msg){
    $user = "smartapps.org@gmail.com";
    $password = "@Apple123";
    $sender = "NSBPP";
    $baseurl ="https://sms.bulksmsprovider.ng/api/?";
 
    //$text = urlencode("This is an example message");
    //$to = "08069504309";
 
    // auth call
    $url = $baseurl."username=".$user."&password=".$password."&message=".urlencode($msg)."&sender=".$sender."&mobiles=".$phone;
 
    // do auth call
    $ret = file($url);
 
    // explode our response. return string is on first line of the data returned
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK") {
 
        $sess_id = trim($sess[1]); // remove any whitespace
 
        // do sendmsg call
        $ret = file($url);
        $send = explode(":",$ret[0]);
 
        if ($send[0] == "ID") {
            return true;
           // echo "status: ". $send[1];
        } else {
            return "send message failed";
        }
    } else {
        //return $ret[0];
        return "Authentication failure: ". $ret[0];
    }
}

//Upload and Crop images 
function upload_passport($path, $ext, $sn) {
    $img_url = 'sign' . $sn . '-' . date('mdYHis.') . $ext;
    move_uploaded_file($path, "temp_img/" . $img_url);
    $resizeObj = new resize("temp_img/" . $img_url);
    $resizeObj->resizeImage(280, 350, 'crop');
    $resizeObj->saveImage("uploads/" . $img_url, 100);
    unlink("temp_img/" . $img_url);
    return $img_url;
}

function genTokens($n){
    $pass = "";
    $allowed_characters=array('1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    for($k=0; $k<intVal($n); $k++){
    $pass.=$allowed_characters[rand(0, count($allowed_characters)-1)];
    }
    return $pass;
}

function ternary_op($val) {
    $op_val = isset($val) ? $val : "";
    return $op_val;
}

function masterRemarks($position) {

    $position = trim($position);

    if ($position == 1) {

        $rem = "Excellent";
    } elseif ($position == 2) {

        $rem = "Very Good";
    } elseif ($position == 3) {

        $rem = "Good";
    } else {

        $rem = "Passed - <i>Can Do Better</i>";
    }

    return $rem;
}

function position($positionValue) {
    $len = strlen($positionValue);
    $lastDigit = substr($positionValue, -1);
    $last2Digits = substr($positionValue, -2);
    $seclast = substr($positionValue, -2, 1);
    if ($len > 1 && $seclast == '1') {

        $posit = $positionValue . "th";
    } elseif ($lastDigit == '1') {

        $posit = $positionValue . "st";
    } elseif ($lastDigit == '2') {

        $posit = $positionValue . "nd";
    } elseif ($lastDigit == '3') {

        $posit = $positionValue . "rd";
    } else {

        $posit = $positionValue . "th";
    }
    return $posit;
}

function principalRemarks($average) {

    $average = trim(round($average));

    if ($average <= 40) {

        $rem = "You need to sit up";
    } elseif ($average >= 41 && $average <= 65) {

        $rem = "Well done! You can do better";
    } elseif ($average >= 66) {

        $rem = "Very Good!. Keep it up";
    }

    return $rem;
}

function teacherRemarks($average) {

    $average = trim(round($average));

    if ($average <= 40) {

        $rem = "Poor Performance, You need to improve";
    } elseif ($average >= 41 && $average <= 65) {

        $rem = "Well done but there is still room for improvement";
    } elseif ($average >= 66 && $average <= 74) {

        $rem = "Very Good!. Keep it up";
    } elseif ($average >= 75 && $average <= 100) {
        $rem = "Great Result!. Keep up the good work";
    }

    return $rem;
}

function dataRead($f) {
    $fieldValue = $_POST['$f'];
    return $fieldValue;
}

function weekDay() {
//timestamp=date("d");
    $n = date("w");
    $n;
    switch ($n) {
        case 1: $d1 = "Monday";
            break;
        case 2: $d1 = "Tuesday";
            break;
        case 3: $d1 = "Wednesday";
            break;
        case 4: $d1 = "Thursday";
            break;
        case 5: $d1 = "Friday";
            break;
        case 6: $d1 = "Saturday";
            break;
        case 7: $d1 = "Sunday";
            break;
    }
    return $d1;
}

function thisTime() {
    $now = date("h:i:s A");
    return $now;
}

function thisMonth() {
    $m = date("m");
    switch ($m) {
        case 1: $month = "January";
            break;
        case 2: $month = "February";
            break;
        case 3: $month = "March";
            break;
        case 4: $month = "April";
            break;
        case 5: $month = "May";
            break;
        case 6: $month = "June";
            break;
        case 7: $month = "July";
            break;
        case 8: $month = "August";
            break;
        case 9: $month = "September";
            break;
        case 10: $month = "October";
            break;
        case 11: $month = "November";
            break;
        case 12: $month = "December";
            break;
    }
    return $month;
}

function toMonth($n) {

    switch ($n) {
        case 1: $month = "January";
            break;
        case 2: $month = "February";
            break;
        case 3: $month = "March";
            break;
        case 4: $month = "April";
            break;
        case 5: $month = "May";
            break;
        case 6: $month = "June";
            break;
        case 7: $month = "July";
            break;
        case 8: $month = "August";
            break;
        case 9: $month = "September";
            break;
        case 10: $month = "October";
            break;
        case 11: $month = "November";
            break;
        case 12: $month = "December";
            break;
    }
    return $month;
}

function grade($score) {

    $score = trim($score);

    if ($score <= 39.99) {

        $grd = 'E';
    } elseif ($score >= 40 and $score <= 54.99) {

        $grd = 'D';
    } elseif ($score >= 55 and $score <= 64.99) {

        $grd = 'C';
    } elseif ($score >= 65 and $score <= 74.99) {

        $grd = 'B';
    } elseif ($score >= 75 and $score <= 100) {

        $grd = 'A';
    } else {
        $grd = '';
    }

    return $grd;
}

function annualAvgRemark($score, $class) {

    $score = trim($score);

    if ($score < 50 && ($class == 'SSS 1' || $class == 'SSS 2')) {

        $grd = 'Failed - To Repeat';
    } elseif ($score < 40 and $class == 'JSS 1') {
        $grd = 'Failed - To Repeat';
    } elseif ($score < 45 and $class == 'JSS 2') {
        $grd = 'Failed - To Repeat';
    } else {

        $grd = 'Pass - PROMOTED';
    }

    return $grd;
}

function termlyAvgRemark($score, $class) {

    $score = trim($score);

    if ($score < 50 && ($class == 'SSS 1' || $class == 'SSS 2')) {

        $grd = 'Failed';
    } elseif ($score < 40 and $class == 'JSS 1') {
        $grd = 'Failed';
    } elseif ($score < 45 and $class == 'JSS 2') {
        $grd = 'Failed';
    } else {

        $grd = 'Pass';
    }

    return $grd;
}

function scoreRemark($score) {

    $score = trim($score);

    if ($score <= 39.99) {

        $grd = 'POOR';
    } elseif ($score >= 40 and $score <= 54.99) {

        $grd = 'FAIR';
    } elseif ($score >= 55 and $score <= 64.99) {

        $grd = 'GOOD';
    } elseif ($score >= 65 and $score <= 74.99) {

        $grd = 'VERY GOOD';
    } elseif ($score >= 75 and $score <= 100) {

        $grd = 'EXCELLENT';
    } else {
        $grd = 'INVALID SCORE';
    }

    return $grd;
}

function remGrade($score) {

    $score = trim($score);

    if ($score == 'F') {

        $grd = "Fail";
    } elseif ($score == 'E') {

        $grd = "Pass";
    } elseif ($score == 'D') {

        $grd = "Pass";
    } elseif ($score == 'C') {

        $grd = "Credit";
    } elseif ($score == 'B') {

        $grd = "Very Good";
    } elseif ($score == 'A') {

        $grd = "Distinction";
    } else {
        $grd = '';
    }

    return $grd;
}

function thisDate() {
    $d = date("d");
    $m = thisMonth();
    $y = date("y");
    $date = $d . " " . $m . ", 20" . $y;
    return $date;
}

function allRows($tname) {
    $r2 = mysqli_query($conn, "select * from `$tname`");
    $no2 = mysqli_num_rows($r2);
    return $no2;
}

function toAge($d1, $m1, $y1) {

    $y2 = "20" . date("y");
    $m2 = date("m");
    $d2 = date("d");
    $y = $y2 - $y1;
    $m = $m2 - $m1;
    $d = $d2 - $d1;
    if ($m < 1 || $d < 1) {
        $y = $y - 1;
    }
    return $y;
}

function convert_number_to_words($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'fourty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

function general_mailtemplate($client,$name,$body, $app_url = "https://mindsourcingoa.com/nsbpp"){
    return "
    <html>
    <head>
      <title>NSBPP | Mail</title>
    <style>
    
      body {
        background-color: #F8F8F8;
        margin-top: 30px;
      }
    
      h2 {
        margin-top: 1px;
        margin-bottom: 10px;
        font-size: 22px;
      }
    
      h4 {
        margin-top: 1px;
        margin-bottom: 10px;
        font-size: 1.0em;
      }
    
      p {
        font-size: 14px;
      }
    
      .header {
        padding-top: 1%;
        padding-bottom: 10px;
        background-color: #fff;
         border-radius: 13px;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);   
      }
    
      .body {
        padding-top: 40px;
        padding-bottom: 50px;
        background-color: #f7f9fc;
        border-radius: 13px;
        justify-content: center;
                align-items: center;
                z-index: 2;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }
    
      .img {
        margin-left: 15px;
      }
    
      .footer {
        padding-top: 20px;
        padding-bottom: 10px;
        background-color: #228d0d ;
        border-radius: 13px;
        text-align: center;
         box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);    
      }
      .logo-default {
        width: auto;
        height: auto;
        max-width: 75px;
        max-height: 75px;
        display: inline-block;
        vertical-align: middle;
      }
    
    
    </style>
    
    </head>
    <body>
        <div class='header'>
          <div class='img'>
               <img src='{$app_url}/assets/images/naslogo.png' alt='NSBPP' class='logo-default'/>
          </div>
        </div>
        <div class='body'>
           <h4 align='center'><strong>{$client}</strong></h4>
           <span style='color:#228d0d; font-size: 12px; margin-left:50px'><i>&#8220;Ensuring Transparency and Value for money&#8221;</i></span>
           <div style='margin-left: 10px; margin-bottom: 10px;' >
             <p style='margin-left:20px;'><strong>Dear {$name},</strong></p>
             <div style='Margin-left: 20px; Margin-right: 20px; '>
                 <p>{$body}</p> 
             </div>
             <p><br></p>
             <p>Regards,</p> 
             <b> 
                <p> NSBPP </p> 
                <span style='color:#228d0d; font-size: 12px; margin-left:50px'><em>&#8220;Ensuring Transparency and Value for money&#8221;</em></span>
             </b>
             <p>For further clarification please send an email to <br>
             <a href='mailto:info@tsl.com.ng'>info@tsl.com.ng</a>
             </p>
          </div>  
        </div>
        <div class='footer'>
          <p>&copy; <a href='#' target='_blank' style='color:white'> SmartApps I.T Limited </a> - 2021. </p>            
        </div>
    
        </body>
    </html>
    ";
}
?>