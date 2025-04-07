<?php
require_once("db.php");


$connexion = mysqli_connect("localhost", "root", "", "tache");
$tacheManager = new TacheManager($connexion);


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $tacheManager->supprimerTache($id);
}

header("Location: index.php");
exit();
?>
