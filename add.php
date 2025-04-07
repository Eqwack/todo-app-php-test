<?php
require_once("db.php");

//ajouter
$connexion = mysqli_connect("localhost", "root", "", "tache");
$tacheManager = new TacheManager($connexion);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $statut = "à faire'";

    $tacheManager->ajouterTache($titre, $description, $statut);

    header("Location: index.php");
    exit();
}
?>
