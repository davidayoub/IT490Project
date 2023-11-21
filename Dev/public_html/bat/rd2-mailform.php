<?php

function send_message()
{
    require_once(__DIR__ . "/phpmailer/PHPMailer.php");
    require_once(__DIR__ . "/phpmailer/SMTP.php");
    require_once(__DIR__ . "/phpmailer/Exception.php");
    $formConfig = json_decode(file_get_contents(__DIR__ . "/rd-mailform.config.json"), true);
    $template = file_get_contents(__DIR__ . '/rd-mailform.tpl');

    date_default_timezone_set('Etc/UTC');

    $recipients = $formConfig['recipientEmail'];
    preg_match_all("/([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)/", $recipients, $addresses, PREG_OFFSET_CAPTURE);

    if (!count($addresses[0])) {
        throw new Exception("Recipients are not set!");
    }

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
        throw new Exception("Please, define type of your form!");
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

    preg_match("/(<!-- #\{BeginInfo\} -->)([^\v]*?)(<!-- #\{EndInfo\} -->)/", $template, $matches, PREG_OFFSET_CAPTURE);
    foreach ($_POST as $key => $value) {
        if ($key != "counter" && $key != "email" && $key != "message" && $key != "form-type" && !empty($value)) {
            $info = str_replace(
                array("<!-- #{BeginInfo} -->", "<!-- #{InfoState} -->", "<!-- #{InfoDescription} -->"),
                array("", ucfirst($key) . ':', $value),
                $matches[0][0]
            );
            $template = str_replace($matches[0][0], $info, $template);
        }
    }
    $template = str_replace("<!-- #{Subject} -->", $subject, $template);

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->setFrom($formConfig['senderEmail'], $formConfig['senderName']);

    foreach ($addresses[0] as $key => $value) {
        $mail->addAddress($value[0]);
    }

    $mail->CharSet = 'utf-8';
    $mail->Subject = $subject;
    $mail->msgHTML($template);

    if (isset($_FILES['attachment'])) {
        foreach ($_FILES['attachment']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $mail->AddAttachment($_FILES['attachment']['tmp_name'][$key], $_FILES['attachment']['name'][$key]);
            }
        }
    }

    if (!$mail->send()) {
        throw new Exception("Error occured while sending email.");
    }
}
