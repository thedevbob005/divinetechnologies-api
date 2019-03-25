<?php

use Slim\Http\Request;
use Slim\Http\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/admin', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'admin.phtml', $args);
});


// Common functions here

// function to save file
function saveB64File($directory, $b64String)
{
    $fileNameWithoutExtention = md5($b64String);
    $tmp = explode(',', $b64String);
    $tmp2 = explode('/', $tmp[0]); // data:image gif;base64
    $tmp3 = explode(';', $tmp2[1]); // gif base64
    $data = base64_decode($tmp[1]);
    $ext = $tmp3[0];
    if($ext == 'jpeg') { $ext = 'jpg'; }
    file_put_contents($directory . DIRECTORY_SEPARATOR . $fileNameWithoutExtention . "." . $ext, $data);
    return $fileNameWithoutExtention . "." . $ext;
};

//functions to send mails
function sendTheMail ($name, $email, $subject, $comment) {
    $mail = new PHPMailer(true);                    // Passing `true` enables exceptions
    $status = '';
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.hostinger.in';                    // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@iruseyewear.com';          // SMTP username
        $mail->Password = '7s4VzFvSW1ux';                     // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('noreply@iruseyewear.com', 'IRUS Website');
        $mail->addAddress('info@ronakoptik.com', 'IRUS Admin');     // Add a recipient
        $mail->addReplyTo($email, $name);
        $mail->addBCC('sbongoog@gmail.com');
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Sent from website : $subject";
        $mail->Body    = '<table border="0" width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse; font-family: \'Roboto\', sans-serif">
    <tr>
        <td bgcolor="#2372ba" height="120"> </td>
        <td bgcolor="#2372ba" style="width: 520px; max-width: 100%" rowspan="2" valign="top">
            <img src="http://iruseyewear.com/img/1_logo_top.png" alt="" style="display: block; padding: 20px 60px; box-sizing: border-box; width: 100%">
            <table border="0" width="100%" cellpadding="20" cellspacing="0" bgcolor="#f6ffff" style="border-collapse: collapse; border-radius: 5px 5px 0 0; border-color: transparent">
                <tr>
                    <td>
                        <h1 style="display: block; padding: 30px 0; text-align: center">Hi !</h1>
                        <p style="font-size: 18px; text-align: justify">'.$name.' sent a message via the contact form on website.</p>
                        <table border="0" width="70%" cellpadding="5" cellspacing="0" style="border-collapse: collapse; font-size: 16px; margin: 10px auto">
                            <tr>
                                <td>Name</td>
                                <td style="text-align: right">'.$name.'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td style="text-align: right">'.$email.'</td>
                            </tr>
                            <tr>
                                <td>Subject</td>
                                <td style="text-align: right">'.$subject.'</td>
                            </tr>
                            <tr>
                                <td>Comment</td>
                                <td style="text-align: right">'.$comment.'</td>
                            </tr>
                        </table>
                        <p style="font-size: 18px">Thank you.<br>Team Artific</p>
                    </td>
                </tr>
            </table>
        </td>
        <td bgcolor="#2372ba" height="220"> </td>
    </tr>
    <tr>
        <td bgcolor="#f4f5f6">&nbsp;</td>
        <td bgcolor="#f4f5f6">&nbsp;</td>
    </tr>
    <tr>
        <td bgcolor="#f4f5f6">&nbsp;</td>
        <td bgcolor="#f4f5f6" style="padding-top: 40px; padding-bottom: 40px; font-size: 12px">
            You have received this mail because you have been set as Admin with IRUS EYEWEAR.
        </td>
        <td bgcolor="#f4f5f6">&nbsp;</td>
    </tr>
</table>';
        $mail->AltBody = 'Please check this mail out using html enabled mail client.';
        $mail->send();
    } catch (Exception $e) {}
};