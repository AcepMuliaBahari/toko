
<?php

use App\Models\GeneralSetting;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

///Mengirim email menggunakan PHPMAILER LIBRARY
if( !function_exists('sendEmail') ){
    function sendEmail($mailConfig){
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->Host = env('EMAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('EMAIL_USERNAME');
        $mail->Password = env('EMAIL_PASSWORD');
        $mail->SMTPSecure = env('EMAIL_ENCRYPTION');
        $mail->Port = env('EMAIL_PORT');
        $mail->setFrom($mailConfig['mail_from_email'],$mailConfig['mail_from_name']);
        $mail->addAddress($mailConfig['mail_recipient_email'],$mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if($mail->send()){
            return true;
        }else{
            return false;
        }
        try {
            $mail->setFrom('from@example.com', 'Your Name');
        } catch (Exception $e) {
            echo 'Pesan Kesalahan: ' . $e->getMessage();
        }
        

    }
}

////general setting
if( !function_exists('get_settings') ){
    function get_settings(){
        $result = null;
        $settings = new GeneralSetting();
        $settings_data = $settings->first();

        if( $settings_data){
            $result = $settings_data;

        }else{
            $settings->insert([
                'site_name'=> 'Laravel',
                'site_email'=> 'hello@example.com'
            ]);
            $new_settings_data = $settings->first();
            $result = $new_settings_data;
        }
        return $result;
    }
}