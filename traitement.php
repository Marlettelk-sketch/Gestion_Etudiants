<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere_id = $_POST['filiere_id'];

    // Vérification basique
    if (!empty($nom) && !empty($prenom) && !empty($filiere_id)) {
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, filiere_id) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $prenom, $filiere_id]);

        // Redirection vers la page principale
        header('Location: index.php');
        exit;
    } else {
        header('Location: index.php');
        exit;
    }
}
?>