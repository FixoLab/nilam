<?php

    $site_owners_email = 'example@example.com'; // Replace this with your own email address
    $site_owners_name = 'Example'; // replace with your name

    $footnote = '<br><br><small>This email is submitted form example.com</small>'; // Optional

    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    
    $error = "";

    if (strlen($fname) < 2) {
        $error['fname'] = "Please Enter Your First Name";
    }

    if (strlen($lname) < 2) {
        $error['lname'] = "Please Enter Your Last Name";
    }

    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please Enter A Valid Email Address";
    }

    if (strlen($message) < 2) {
        $error['message'] = "Please Leave A Comment.";
    }

    if (!$error) {

        require_once('phpmailer/class.phpmailer.php');
        $mail = new PHPMailer();

        $mail->From = $email;
        $mail->FromName = $fname;
        $mail->Subject = 'Contact Form';
        $mail->AddAddress($site_owners_email, $site_owners_name);
        $mail->IsHTML(true);
        $mail->Body = '<b>First Name:</b> '. $fname . " " . $lname .'<br/><b>E-mail:</b> '. $email .'<br/><b>Phone:</b> '. $phone .'<br/><br/>' . $message . $footnote;

        $mail->Send();

        echo "<div class='alert alert-success'  role='alert'>Thanks <em>" . $fname . " " . $lname . "</em>. Your message has been sent.</div>";

    } else {

        $response = (isset($error['fname'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['fname'] . "</div> \n" : null;
        $response = (isset($error['lname'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['lname'] . "</div> \n" : null;
        $response .= (isset($error['email'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['email'] . "</div> \n" : null;
        $response .= (isset($error['message'])) ? "<div class='alert alert-danger'  role='alert'>" . $error['message'] . "</div>" : null;

        echo $response;

    }

?>
