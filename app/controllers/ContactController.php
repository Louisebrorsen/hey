<?php

class ContactController
{
    public function send (): void{

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: /');
            exit();
        }

        $name = cleanInput($_POST['name']);
        $email = cleanInput($_POST['email']);
        $subject = cleanInput($_POST['subject']);
        $message = cleanInput($_POST['message']);

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        $_SESSION['contact_success'] = "Din besked er sendt. Tak for din henvendelse!";
        header('Location: /');
        exit();
    }
}



/* contact_messages database navn til contactform */