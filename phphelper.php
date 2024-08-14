<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function send_mail($receiver, $body, $sub)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';    //edit
    $mail->Host = "mail.smtp2go.com";
    $mail->Port = 2525;    //edit
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    // $mail->SMTPDebug=2;  //edit
    $mail->Username = "bitotechnologies.com";
    $mail->Password = "GU9uW06kCqm55vu4";
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //edit
    $mail->SetFrom("noreply@bitocloud.in", "Bito Technologies Pvt. Ltd.");
    $mail->Subject = $sub;
    $mail->Body = $body;
    $mail->AddAddress($receiver);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}


function send_whatsapp_msg($number, $msg)
{
    try {
        $curl = curl_init();
        $url = implode('?', [
            'http://api.alerthub.in/api/send',
            http_build_query([
                'apiusername'      => 'api_F1A0rI7lt',
                'apipassword'     => '7b04Qfn45eKJo48P',
                'requestid' => 'tesuytuyt1',
                'jid'    => '91' . $number,
                'content' => $msg,
                'messagetype' => 'TEXT',
                'from' => '916392865568'
            ])
        ]);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

function sendMsg($number, $sendMessage){
    try {
        $url = implode('?', [
            'http://api.alerthub.in/api/send',
            http_build_query([
                'apiusername'      => 'api_F1A0rI7lt',
                'apipassword'     => '7b04Qfn45eKJo48P',
                'requestid' => 'tesuytuyt1',
                'jid'    => '91' . $number,
                'content' => $sendMessage,
                'messagetype' => 'TEXT',
                'from' => '916392865568'
            ])
        ]);

        $vr = file_get_contents($url);
        return $vr;
    } catch (\Throwable $th) {
        throw $th;
    }
}