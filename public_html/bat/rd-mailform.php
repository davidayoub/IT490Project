<?php
$formConfigFile = file_get_contents("rd-mailform.config.json");
$formConfig = json_decode($formConfigFile, true);

$page = isset($_POST['page']);
date_default_timezone_set('Etc/UTC');

try {
    //require_once "./phpmailer/PHPMailerAutoload.php";
    require_once "./phpmailer/PHPMailer.php";
    require_once "./phpmailer/SMTP.php";
    require_once "./phpmailer/Exception.php";
    $recipients = $formConfig['recipientEmail'];

    preg_match_all("/([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)/", $recipients, $addresses, PREG_OFFSET_CAPTURE);

    if (!count($addresses[0])) {
        //die('MF001');
        flash('Recipients are not set!');
        redirect($page);
    }
    /*
    function getRemoteIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    if (preg_match('/^(127\.|192\.168\.|::1)/', getRemoteIPAddress())) {
        die('MF002');
    }
*/
    $template = file_get_contents('rd-mailform.tpl');
    if (isset($_POST['form-type'])) {
        switch ($_POST['form-type']) {
            case 'contact':
                $subject = 'A message from a new Client';
                break;
            case 'subscribe':
                $subject = 'Subscribe request';
                break;
            case 'order':
                $subject = 'Order request';
                break;
            case 'password':
                $subject = 'Password reset request';
                break;
            default:
                $subject = 'A message from a new Client';
                break;
        }
    } else {
        //die('MF004');
        flash('Please, define type of your form!');
        redirect($page);
    }

    if (isset($_POST['email'])) {
        $template = str_replace(
            array("<!-- #{FromState} -->", "<!-- #{FromEmail} -->"),
            array("Email:", $_POST['email']),
            $template
        );
    }

    if (isset($_POST['message'])) {
        $template = str_replace(
            array("<!-- #{MessageState} -->", "<!-- #{MessageDescription} -->"),
            array("Message:", $_POST['message']),
            $template
        );
    }

    // In a regular expression, the character \v is used as "anything", since this character is rare
    preg_match("/(<!-- #\{BeginInfo\} -->)([^\v]*?)(<!-- #\{EndInfo\} -->)/", $template, $matches, PREG_OFFSET_CAPTURE);
    foreach ($_POST as $key => $value) {
        if ($key != "counter" && $key != "email" && $key != "message" && $key != "form-type" && $key != "g-recaptcha-response" && !empty($value)) {
            $info = str_replace(
                array("<!-- #{BeginInfo} -->", "<!-- #{InfoState} -->", "<!-- #{InfoDescription} -->"),
                array("", ucfirst($key) . ':', $value),
                $matches[0][0]
            );

            $template = str_replace("<!-- #{EndInfo} -->", $info, $template);
        }
    }

    $template = str_replace(
        array("<!-- #{Subject} -->", "<!-- #{SiteName} -->"),
        array($subject, $_SERVER['SERVER_NAME']),
        $template
    );
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    //$mail = new PHPMailer();


    if ($formConfig['useSmtp']) {
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        $mail->Debugoutput = 'html';

        // Set the hostname of the mail server
        $mail->Host = $formConfig['host'];

        // Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $formConfig['port'];

        // Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->smtpConnect([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);

        // Username to use for SMTP authentication
        $mail->Username = $formConfig['username'];

        // Password to use for SMTP authentication
        $mail->Password = $formConfig['password'];
    }

    $mail->From = $_POST['email'];

    # Attach file
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $mail->AddAttachment(
            $_FILES['file']['tmp_name'],
            $_FILES['file']['name']
        );
    }

    if (isset($_POST['name'])) {
        $mail->FromName = $_POST['name'];
    } else {
        $mail->FromName = "Site Visitor";
    }

    foreach ($addresses[0] as $key => $value) {
        $mail->addAddress($value[0]);
    }

    $mail->CharSet = 'utf-8';
    $mail->Subject = $subject;
    $mail->MsgHTML($template);
    $mail->send();

    //print_r($_POST);
    //echo (($_POST['form-type']));
    //die('MF000');
    flash('Successfully sent!');
    redirect($page);
} catch (phpmailerException $e) {
    //die('MF254');
    flash('Something went wrong with PHPMailer!');
    redirect($page);
} catch (Exception $e) {
    //die('MF255');
    flash('Something went wrong with PHPMailer!');
    redirect($page);
}


function send_message($name, $email, $message)
{
    $to = "your@email.com";
    $subject = "New message from $name";
    $headers = "From: $email" . "\r\n" .
        "Reply-To: $email" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();
    $body = $message;

    if (mail($to, $subject, $body, $headers)) {
        flash("Message sent successfully!");
        redirect("/");
    } else {
        flash("An error occurred while sending the message. Please try again later.");
        redirect("/");
    }
}
