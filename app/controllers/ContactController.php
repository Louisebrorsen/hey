<?php

class ContactController
{
    public function send(): void
    {

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: /');
            exit();
        }

        $name = cleanInput($_POST['name']);
        $email = cleanInput($_POST['email']);
        $subject = cleanInput($_POST['subject']);
        $message = cleanInput($_POST['message']);
        $fax = cleanInput($_POST['fax']);

        if (!empty($fax)) {
            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO spam_message (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
            $stmt->execute([
                'name'    => $name,
                'email'   => $email,
                'subject' => $subject,
                'message' => $message,
            ]);

            $_SESSION['contact_success'] = "Din besked er sendt. Tak for din henvendelse!";
            header('Location: ?url=#contact');
            exit();
        }

        $error = [];

        if (empty($name) || strlen($name) < 2) {
            $error[] = "Udfyld venligst dit navn.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Udfyld venligst en gyldig email.";
        }

        if (empty($subject) || strlen($subject) < 5) {
            $error[] = "Emnet skal være mindst 5 tegn langt.";
        }

        if (empty($message) || strlen($message) < 10) {
            $error[] = "Beskeden skal være mindst 10 tegn langt.";
        }


        if (!empty($error)) {
            $_SESSION['contact_error'] = implode("<br>", $error);
            header('Location: ?url=#contact');
            exit();
        }

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO contact_message (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ]);

        $_SESSION['contact_success'] = "Din besked er sendt. Tak for din henvendelse!";
        header('Location: ?url=#contact');
        exit();
    }
}
