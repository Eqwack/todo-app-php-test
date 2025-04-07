<?php
require_once("db.php");        



$connexion = mysqli_connect("localhost", "root", "", "tache");


$tacheManager = new TacheManager($connexion);


$resultats = [];
$motCle = "";


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $motCle = htmlspecialchars($_GET['query']);
    $resultats = $tacheManager->rechercherTaches($motCle);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Tâches</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h1>Recherche de Taches</h1>

        <form method="get" action="search.php">
            <input type="text" name="query" placeholder="Rechercher par titre ou description" value="<?= htmlspecialchars($motCle) ?>" required>
            <button type="submit">Rechercher</button>
            <a href="index.php" class="btn">Retour à l'accueil</a>
        </form>

        <?php if ($motCle !== ""): ?>
           
            <?php if (count($resultats) > 0): ?>
                <table  cellpadding="10">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date de création</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultats as $tache): ?>

                            <tr>
                                <td><?= htmlspecialchars($tache->getTitre()) ?></td>
                                <td><?= htmlspecialchars($tache->getDescription()) ?></td>
                                <td><?= $tache->getDate_creation() ?></td>
                                <td><?= $tache->getStatut() ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $tache->getID() ?>" class="btn edit">Modifier</a>
                                    <a href="delete.php?id=<?= $tache->getID() ?>" class="btn delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                                </td>
                            </tr>

                            
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune tache trouvee</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
