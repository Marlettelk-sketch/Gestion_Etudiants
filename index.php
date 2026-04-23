<?php
require 'connexion.php';

// Récupérer les filières
$stmt = $pdo->query("SELECT * FROM filieres");
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des étudiants</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="container">
        <h1>Gestion des étudiants</h1>

        <!-- Formulaire d'ajout -->
        <div class="form-section">
            <h2>Ajouter un étudiant</h2>
            <form action="traitement.php" method="POST" id="formAjout">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="Entrez le nom">
                    <span class="error" id="errorNom"></span>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Entrez le prénom">
                    <span class="error" id="errorPrenom"></span>
                </div>
                <div class="form-group">
                    <label for="filiere">Filière</label>
                    <select id="filiere" name="filiere_id">
                        <option value="">-- Choisir une filière --</option>
                        <?php foreach ($filieres as $filiere): ?>
                            <option value="<?= $filiere['id'] ?>"><?= $filiere['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn">Ajouter</button>
            </form>
        </div>
        <!-- Tableau des étudiants -->
<div class="table-section">
    <h2>Liste des étudiants</h2>
    <?php
    $stmt = $pdo->query("
        SELECT e.id, e.nom, e.prenom, f.nom AS filiere 
        FROM etudiants e 
        JOIN filieres f ON e.filiere_id = f.id
        ORDER BY e.id DESC
    ");
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if (count($etudiants) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Filière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
            <tr>
                <td><?= $etudiant['id'] ?></td>
                <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                <td><?= htmlspecialchars($etudiant['filiere']) ?></td>
                <td class="actions">
                    <a href="update.php?id=<?= $etudiant['id'] ?>" class="btn btn-edit">Modifier</a>
                    <a href="delete.php?id=<?= $etudiant['id'] ?>" class="btn btn-delete" onclick="return confirmerSuppression()">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="empty">Aucun étudiant enregistré pour le moment.</p>
    <?php endif; ?>
</div>

    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>