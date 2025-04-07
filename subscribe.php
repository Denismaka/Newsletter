<?php
require 'db.php';
require 'vendor/autoload.php'; // Inclusion de php mailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Correction ici
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Vérifie si l'email est déjà inscrit 
    $checkemail = "SELECT * FROM newsletter WHERE email='$email'"; // Correction ici
    $result = mysqli_query($conn, $checkemail);

    if (mysqli_num_rows($result) > 0) {
        echo "Cet email est déjà inscrit.";
    } else {
        // Insère l'email dans la db
        $query = "INSERT INTO newsletter (email) VALUES ('$email')";
        if (mysqli_query($conn, $query)) {
            // Configuration de PhpMailer pour l'envoi des emails
            $mail = new PHPMailer(true);
            try {
                // Configuration SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true; // Correction ici
                $mail->Username = 'makadenis370@gmail.com'; // Remplace par ton adresse gmail
                $mail->Password = 'frppvxtymsnmlfps'; // Remplace par ton Mdp ou Mdp d'application gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('from@example.com', 'Newsletter');
                $mail->addAddress($email, 'Newsletter'); // Destinataire
                $mail->Subject = 'Bienvenue à notre Newsletter';
                $mail->Body = "Bonjour, \n\nMerci de vous être inscrit à notre newsletter ! Vous recevrez bientôt nos dernières nouvelles. \n\nCordialement, \nL'équipe";

                $mail->send();
                echo "Inscription réussie et email de confirmation envoyé à $email.";
            } catch (Exception $e) {
                echo "Inscription réussie, mais l'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        } else {
            echo "Erreur lors de l'inscription: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn); // Ajout du point-virgule
