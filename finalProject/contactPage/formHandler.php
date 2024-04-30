<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 2);

//PHP Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'smtpCredentials.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot field
    $honeypot = $_POST['honeypot'];

    // Check if honeypot field is empty
    if (!empty($honeypot)) {
        // If honeypot field is not empty, it's likely a bot submission
        // Redirect back to contact form page with error message or display an error message
        header("Location: contact_form.php?status=error");
        exit; // Stop further execution
    }

    // Proceed with processing the form if honeypot is valid
    $contact_name = $_POST['contact_name'];
    $contact_email = $_POST['contact_email'];
    $reason = $_POST['reason'];
    $comments = $_POST['comments'];

    // Format date
    $date = date("m/d/Y");

    // Send confirmation email to the user
    $to_user = $contact_email;
    $subject_user = "We Received Your Inquiry";
    $message_user = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>Contact Form Confirmation</title>
        <style>
            /* Email styling */
        </style>
    </head>
    <body>
        <h2>Thank you for reaching out!</h2>
        <p>We have received your information and will respond to you shortly.</p>
        <p>Contact Information:</p>
        <ul>
            <li><strong>Name:</strong> $contact_name</li>
            <li><strong>Email:</strong> $contact_email</li>
            <li><strong>Reason for Contact:</strong> $reason</li>
            <li><strong>Comments:</strong> $comments</li>
            <li><strong>Date of Contact:</strong> $date</li>
        </ul>
    </body>
    </html>";

    // Send notification email to admin
    $to_admin = "contact@natalieblanco.co";
    $subject_admin = "New Contact Form Submission";
    $message_admin = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>New Contact Form Submission</title>
        <style>
            /* Email styling */
        </style>
    </head>
    <body>
        <h2>New Contact Form Submission</h2>
        <p>A new contact form submission has been received.</p>
        <p>Contact Information:</p>
        <ul>
            <li><strong>Name:</strong> $contact_name</li>
            <li><strong>Email:</strong> $contact_email</li>
            <li><strong>Reason for Contact:</strong> $reason</li>
            <li><strong>Comments:</strong> $comments</li>
            <li><strong>Date of Contact:</strong> $date</li>
        </ul>
    </body>
    </html>";


    // Send notification email to admin
    $to_admin = "contact@natalieblanco.co";
    $subject_admin = "New Contact Form Submission";
    $message_admin = "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <title>New Contact Form Submission</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }
            .container {
                margin: 0 auto;
                max-width: 600px;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #333;
            }
            ul {
                list-style-type: none;
                padding: 0;
                text-align: left;
            }
            li {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Contact Form Submission</h2>
            <p>A new contact form submission has been received.</p>
            <p>Contact Information:</p>
            <ul>
                <li><strong>Name:</strong> $contact_name</li>
                <li><strong>Email:</strong> $contact_email</li>
                <li><strong>Reason for Contact:</strong> $reason</li>
                <li><strong>Comments:</strong> $comments</li>
                <li><strong>Date of Contact:</strong> $date</li>
            </ul>
        </div>
    </body>
    </html>";




    // PHP Mailer
    $mail_user = new PHPMailer(true);
    $mail_admin = new PHPMailer(true);

    // Enable verbose debugging
    //$mail_user->SMTPDebug = 2;
    //$mail_admin->SMTPDebug = 2;

    // Log SMTP debug output to a file
    //$mail_user->Debugoutput = function ($str, $level) {
    //    file_put_contents('smtp_debug.log', '[' . date('Y-m-d H:i:s') . '] ' . $str . PHP_EOL, FILE_APPEND);
    //};
    //$mail_admin->Debugoutput = function ($str, $level) {
    //    file_put_contents('smtp_debug.log', '[' . date('Y-m-d H:i:s') . '] ' . $str . PHP_EOL, FILE_APPEND);
    //};



    try {
        // Server settings
        $mail_user->isSMTP();
        $mail_user->Host = $smtpHost;
        $mail_user->SMTPAuth = true;
        $mail_user->Username = $smtpUsername;
        $mail_user->Password = $smtpPassword;
        $mail_user->SMTPSecure = 'ssl';
        $mail_user->Port = $smtpPort;

        $mail_admin->isSMTP();
        $mail_admin->Host = $smtpHost;
        $mail_admin->SMTPAuth = true;
        $mail_admin->Username = $smtpUsername;
        $mail_admin->Password = $smtpPassword; // Use hashed password here
        $mail_admin->SMTPSecure = 'ssl';
        $mail_admin->Port = $smtpPort;

        // Recipients
        $mail_user->setFrom("contact@natalieblanco.co");
        $mail_user->addAddress($to_user);
        $mail_user->isHTML(true);
        $mail_user->Subject = $subject_user;
        $mail_user->Body = $message_user;

        $mail_admin->setFrom("contact@natalieblanco.co");
        $mail_admin->addAddress($to_admin);
        $mail_admin->isHTML(true);
        $mail_admin->Subject = $subject_admin;
        $mail_admin->Body = $message_admin;

        // Send emails
        $mail_user->send();
        $mail_admin->send();

        // Direct to thank you page
        header("Location: thankYou.html");
        exit;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
} else {
    // Redirect back to contact form page with error message
    header("Location: contact_form.php?status=error");
    exit;
}
