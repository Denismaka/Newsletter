<?php
$host = '127.0.0.1'; // Serveur local 
$db = 'newsletter_db'; // Nom de la base de donnée
$user = 'root'; // Utilisateur MySQL
$pass = ''; // Mdp
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Echec de la connexion:" . mysqli_connect_error());
}
