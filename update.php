<?php
require 'connexion.php';

// Récupérer l'étudiant à modifier
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    header('Location: index.php');
    exit;
}

// Récupérer les filières
$stmt2 = $pdo->query("SELECT * FROM filieres");
$filieres = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere_id = $_POST['filiere_id'];

    if (!empty($nom) && !empty($prenom) && !empty($filiere_id)) {
        $stmt3 = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, filiere_id = ? WHERE id = ?");
        $stmt3->execute([$nom, $prenom, $filiere_id, $id]);

        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="container">
        <h1>Gestion des étudiants</h1>

        <div class="form-section">
            <h2>Modifier un étudiant</h2>
            <form action="update.php?id=<?= $id ?>" method="POST" id="formAjout">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>">
                    <span class="error" id="errorNom"></span>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>">
                    <span class="error" id="errorPrenom"></span>
                </div>
                <div class="form-group">
                    <label for="filiere">Filière</label>
                    <select id="filiere" name="filiere_id">
                        <option value="">-- Choisir une filière --</option>
                        <?php foreach ($filieres as $filiere): ?>
                            <option value="<?= $filiere['id'] ?>" 
                                <?= $filiere['id'] == $etudiant['filiere_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($filiere['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn">Enregistrer</button>
                    <a href="index.php" class="btn" style="background:#95a5a6; text-decoration:none;">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>