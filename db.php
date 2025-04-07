<?php 
class Tache{
    private $ID;
    private $Titre;
    private $Description;
    private  $Date_creation;
    private $Statut;


    public function __construct( $ID,$Titre,$Description,$Date_creation,$Statut) {
      $this->ID=$ID;
      $this->Titre=htmlspecialchars($Titre, ENT_QUOTES, 'UTF-8');
      $this->Description=htmlspecialchars($Description, ENT_QUOTES, 'UTF-8');
      $this->Date_creation=$Date_creation;
      $this->Statut=$Statut;
     
  }
  public function getID(){return $this->ID;}
  public function getTitre(){return $this->Titre;}
  public function getDescription(){return $this->Description;}
  public function getDate_creation(){return $this->Date_creation;}
  public function getStatut(){return $this->Statut;}



}

class TacheManager {
    private $taches = [];
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;

        if (!$connexion) {
            throw new Exception("Erreur de connexion à la base de données");
        }

        $stmt = mysqli_prepare($connexion, "SELECT * FROM taches");
        if ($stmt) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($ligne = mysqli_fetch_object($result)) {
                $this->taches[] = new Tache(
                    $ligne->id, 
                    $ligne->titre, 
                    $ligne->description, 
                    $ligne->date_creation, 
                    $ligne->statut
                );
            }
            mysqli_stmt_close($stmt);
        } else {
            error_log("Erreur SQL : " . mysqli_error($connexion));
        }
    }

    public function getTaches() {
        return $this->taches;
    }

    public function getTachesTable() {
        $tachestable = [];
        foreach ($this->taches as $t) {
            $tachestable[] = [ 
                'ID' => $t->getID(),
                'Titre' => $t->getTitre(),
                'Description' => $t->getDescription(),
                'Date_creation' => $t->getDate_creation(),
                'Statut' => $t->getStatut()
            ];
        }
        return $tachestable;
    }

  
    public function ajouterTache($titre, $description, $statut) {
        $date = date('Y-m-d');
        $stmt = mysqli_prepare($this->connexion, "INSERT INTO taches (titre, description, date_creation, statut) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $titre, $description, $date, $statut);
       
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function supprimerTache($id) {
        $stmt = mysqli_prepare($this->connexion, "DELETE FROM taches WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

   
    public function modifierTache($id, $titre, $description, $statut) {
        $stmt = mysqli_prepare($this->connexion, "UPDATE taches SET titre = ?, description = ?, statut = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $titre, $description, $statut, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function rechercherTaches($motCle) {
        $resultats = [];
        foreach ($this->taches as $tache) {
            if (stripos($tache->getTitre(), $motCle) !== false || stripos($tache->getDescription(), $motCle) !== false) {
                $resultats[] = $tache;
            }
        }
        return $resultats;
    }
    
    
   
}


















?>