<?php
require_once("db.php");


$connexion = mysqli_connect("localhost", "root", "", "tache");
$tacheManager = new TacheManager($connexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];

    $tacheManager->modifierTache($id, $titre, $description, $statut);
    header("Location: index.php");
    exit();
}
 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $taches = $tacheManager->getTaches();
    $tacheTrouvee = null;

    foreach ($taches as $tache) {
        if ($tache->getID() == $id) {
            $tacheTrouvee = $tache;
            break;
        }
    }

    if (!$tacheTrouvee) {
        echo "Tache introuvable";
        exit();
    }
} else {
    echo "ID manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la tâche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Modifier la tache</h1>
    
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?= $tacheTrouvee->getID() ?>">

        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" value="<?= $tacheTrouvee->getTitre() ?>" required><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description"><?= $tacheTrouvee->getDescription() ?></textarea><br>

        <label for="statut">Statut :</label>
        <select name="statut" id="statut">
            
            <option value="à faire" <?= $tacheTrouvee->getStatut() == "à faire" ? "selected" : "" ?>>à faire</option>
            <option value="fait" <?= $tacheTrouvee->getStatut() == "fait" ? "selected" : "" ?>>fait</option>
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>
    </div>
</body>
</html>
