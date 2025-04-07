
    <?php  
    require_once("db.php");
    $connexion = mysqli_connect("localhost", "root", "","tache");
    
    $tacheManager = new TacheManager($connexion);


    
    
    ?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Taches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gestionnaire de Taches</h1>
          <!-- recheche tache tgg -->
          <form method="get" action="search.php">
            <input type="text" name="query" placeholder="Rechercher une tache">
            <button type="submit">Rechercher</button>
        </form>
     

        <!-- ajout de tache -->
        <div class="add-task-form">
            <h2>Ajouter une nouvelle tache</h2>
            <form action="add.php" method="post">

                <div class="form-group">

                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">

                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn">Ajouter</button>
            </form>

        </div>
      

        <!-- liste des taches -->
        <div class="task-list">
            <h2>Liste des taches</h2>
     
                <table>
                  
                <?php foreach ($tacheManager->getTaches() as $tache): ?>
                    <tr>
                        <td><?= htmlspecialchars($tache->getTitre()) ?></td>
                        <td><?= htmlspecialchars($tache->getDescription()) ?></td>
                        <td><?= $tache->getDate_creation() ?></td>
                        <td><?= $tache->getStatut() ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $tache->getID() ?>" class="btn edit">Modifier</a>
                            <a href="delete.php?id=<?= $tache->getID() ?>" class="btn delete" onclick="return confirm('Etes-vous sur de supprimer cette tache ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                                    
                   
                </table>
                
                    
    </div>

    
</body>
</html>