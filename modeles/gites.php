<?php

declare(strict_types=1);
require_once "modeles/database.php";

class Gites extends Database
{

     //Creation des attributs privés de la classe Gites
     private $id_gite;
     private $nom_gite;
     private $description_gite;
     private $img_gite;
     private $prix_gite;
     private $nbr_sdb;
     private $zone_geo;
     private $disponible;
     private $date_arrivee;
     private $date_depart;
     private $type_gite;
 
     private $id_commentaire;

    public function affichergites() {
        $connexion=$this-> getPDO();
        $sql = "SELECT * FROM `gites` INNER JOIN departement ON gites.zone_geo=departement.departement_id INNER JOIN categories ON gites.gite_categorie = categories.id_categorie
        ;

        ";
        $resultat=$connexion->query($sql);
        return $resultat;
    }
    

    public function getGiteById(){
        
        $db = $this->getPDO();
        $sql = "SELECT * FROM gites 
                                    INNER JOIN categories ON gites.gite_categorie = categories.id_categorie
                                    INNER JOIN  departement ON gites.zone_geo = departement.departement_id          
                                    INNER JOIN commentaires ON gites.commentaire_id = commentaires.id_commentaire
                                   
                                    WHERE gites.id_gite = ?";
        $request = $db->prepare($sql);
        
        $id = $_GET['id_gite'];
        $request->bindParam(1, $id);
        $request->execute();
        $details = $request->fetch();
        return $details;
    }

        //Cette methode est destinée a ajouter un gites de la table phpMyADmin a l'aide d'un formulaire

    public function setGites(){
        
        if(isset($_POST['nom_gite'])){
            $this->nom_gite = trim(htmlspecialchars($_POST['nom_gite']));
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nom du gite</p>";
        }

        //LA DESCRIPTION
        if(isset($_POST['description_gite'])){
            $this->description_gite = trim(htmlspecialchars($_POST['description_gite']));
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ description du gite</p>";
        }

        //UPLOAD D' IMAGE
        if(isset($_FILES['img_gite'])){
            $dossierDestination = "assets/img/";
            $img_gite = $dossierDestination. basename($_FILES['img_gite']['name']);
            $_POST['img_gite'] = $img_gite;
            if(move_uploaded_file($_FILES['img_gite']['tmp_name'], $img_gite)){
                echo '<p class="alert alert-success">Le fichier est valide et à été téléchargé avec succès !</p>';
            }else{
                echo '<p class="alert-danger">Une erreur s\'est produite, le fichier n\'est pas valide !</p>';
            }
        }

        //LE POSTE DE L'IMAGE
        if(isset($_POST['img_gite'])){
            $this->img_gite = $_POST['img_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ image du gite</p>";
        }

        
        //LE NOMBRE DE SALLE DE BAINS
        if(isset($_POST['nbr_sdb'])){
            $this->nbr_sdb= $_POST['nbr_sdb'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nombre de salle de bain</p>";
        }

        //LA REGION DE FRANCE
        if(isset($_POST['zone_geo'])){
            $this->zone_geo = $_POST['zone_geo'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ departement</p>";
        }
        //LE PRIX DU GITE 
        if(isset($_POST['prix_gite'])){
            $this->prix = $_POST['prix_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ prix du gite</p>";
        }

        //LE BOOLEEN GITE DISPO OU NON
        if(isset($_POST['disponible'])){
            $this->disponible = $_POST['disponible'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ disponible</p>";
        }

        //LA DATE DE DISPO DU GITE
        if(isset($_POST['date_arrivee'])){
            $this->date_arrivee = $_POST['date_arrivee'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date d'arrivée</p>";
        }
        //LA  DATE DE FIN DE LOCATION
        if(isset($_POST['date_depart'])){
            $this->date_depart = $_POST['date_depart'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date de depart</p>";
        }

        //Cle etrangère gite categorie

        if(isset($_POST['type_gite'])){
            $this->type_gite = $_POST['type_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ type de gite</p>";
        }

        //LES COMMENTAIRE = champs caché avec valeurs par defaut

        if(isset($_POST['commentaires'])){
            $this->id_commentaire = $_POST['commentaires'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ commentaire de gite</p>";
        }

        //Verifié que la date d'arrivée n'est pas supérieur à la date départ = une erreur
        if(isset($this->date_depart) > isset($this->date_arrivee)){
            echo "<p class='alert-danger p-2'>ATTENTION : la date d'arrivée est supérieur à la date de part !</p>";
        }

        //var_dump($_POST['nom_gite']);
        //var_dump($_POST['description_gite']);
        //var_dump($_POST['img_gite']);
        //var_dump($_POST['nbr_chambre']);
        //var_dump($_POST['nbr_sdb']);
        //var_dump($_POST['zone_geo']);
        //var_dump($_POST['prix']);
        //var_dump($_POST['disponible']);
        //var_dump($_POST['date_arrivee']);
        //var_dump($_POST['date_depart']);
        //var_dump($_POST['type_gite']);



        //Connexion a PDO + requète SQL + requète préparée + execution
        try {
            //Connexion de puis la methode PDO de la classe mere
            $db = $this->getPDO();
            //La requète SQL

            $sql = "INSERT INTO gites
            (nom_gite, description_gite, img_gite, nbr_sdb, zone_geo, prix_gite, disponible, date_arrivee, date_depart, gite_categorie, commentaire_id) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
            //Lutte contre les injections SQL
            $req = $db->prepare($sql);
            //Lie les 12 champs du formulaire a la requète SQL
            $req->bindParam(1, $this->nom_gite);
            $req->bindParam(2, $this->description_gite);
            $req->bindParam(3, $this->img_gite);
            $req->bindParam(5, $this->nbr_sdb);
            $req->bindParam(6, $this->zone_geo);
            $req->bindParam(7, $this->prix);
            $req->bindParam(8, $this->disponible);
            $req->bindParam(9, $this->date_arrivee);
            $req->bindParam(10, $this->date_depart);
            $req->bindParam(11, $this->type_gite);
            $req->bindParam(12, $this->id_commentaire);
            //On execute la requète et on retourne uhn tableau associatif
            $insert = $req->execute(
                array(
                    $this->nom_gite,
                    $this->description_gite,
                    $this->img_gite,
                    $this->nbr_sdb,
                    $this->zone_geo,
                    $this->prix,
                    $this->disponible,
                    $this->date_arrivee,
                    $this->date_depart,
                    $this->type_gite,
                    $this->id_commentaire
                ));
            //Si l'execution fonctionne
            //On fais une redirection sur une page de succès Sinon on affiche une erreur
            if ($insert) {
                header("Location: confirmer-ajout-gite");
            } else {
                echo "<p class='alert-danger p-3'>Une erreur est survenue durant l'ajout du gite, merci de verifié tous les champs !</p>";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du gites ! Merci de recommencer !" . $e->getMessage();
        }

    }

    public function deleteGite(){
        $db = $this->getPDO();
        $id = $_GET['id_gite'];
        $sql = "DELETE FROM gites WHERE id_gite = ?";
        $req = $db->prepare($sql);
        $req->bindParam(1, $id);
        $req->execute();
        if($req){
            header("Location: supprimer-gite");
        }else{
            echo "<p class='alert-warning p-2'>Une erreur est survenue duarant la supression de cet élément.</p>";
        }
    }

    //mettre a un jour un gite
    public function updateGite(){
        $db = $this->getPDO();
        
        if(isset($_POST['nom_gite'])){
            $this->nom_gite = trim(htmlspecialchars($_POST['nom_gite']));
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nom du gite</p>";
        }

        //LA DESCRIPTION
        if(isset($_POST['description_gite'])){
            $this->description_gite = trim(htmlspecialchars($_POST['description_gite']));
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ description du gite</p>";
        }

        //UPLOAD D' IMAGE
        if(isset($_FILES['img_gite'])){
            $dossierDestination = "assets/img/";
            $img_gite = $dossierDestination. basename($_FILES['img_gite']['name']);
            $_POST['img_gite'] = $img_gite;
            if(move_uploaded_file($_FILES['img_gite']['tmp_name'], $img_gite)){
                echo '<p class="alert alert-success">Le fichier est valide et à été téléchargé avec succès !</p>';
            }else{
                echo '<p class="alert-danger">Une erreur s\'est produite, le fichier n\'est pas valide !</p>';
            }
        }

        //LE POSTE DE L'IMAGE
        if(isset($_POST['img_gite'])){
            $this->img_gite = $_POST['img_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ image du gite</p>";
        }

        //LE NOMBRE DE CHAMBRE
        if(isset($_POST['nbr_chambre'])){
            $this->nbr_chambre = $_POST['nbr_chambre'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nombre de chambre</p>";
        }
        //LE NOMBRE DE SALLE DE BAINS
        if(isset($_POST['nbr_sdb'])){
            $this->nbr_sdb= $_POST['nbr_sdb'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ nombre de salle de bain</p>";
        }

        //LA REGION DE FRANCE
        if(isset($_POST['zone_geo'])){
            $this->zone_geo = $_POST['zone_geo'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ departement</p>";
        }
        //LE PRIX DU GITE / SEMAINE
        if(isset($_POST['prix_gite'])){
            $this->prix = $_POST['prix_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ prix du gite</p>";
        }

        //LE BOOLEESN GITE DISPO OU NON
        if(isset($_POST['disponible'])){
            $this->disponible = $_POST['disponible'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ disponible</p>";
        }

        //LA DATE DE DISPO DU GITE
        if(isset($_POST['date_arrivee'])){
            $this->date_arrivee = $_POST['date_arrivee'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date d'arrivée</p>";
        }
        //LA DERNIERE DATE DE FIN DE LOCATION
        if(isset($_POST['date_depart'])){
            $this->date_depart = $_POST['date_depart'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ date de depart</p>";
        }

        //Cle etrangère gite categorie

        if(isset($_POST['type_gite'])){
            $this->type_gite = $_POST['type_gite'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ type de gite</p>";
        }

        //LES COMMENTAIRES'' = champs caché avec valeurs par defaut

        if(isset($_POST['commentaires'])){
            $this->id_commentaire = $_POST['commentaires'];
        }else{
            echo "<p class='alert-danger p-2'>Merci de remplir le champ commentaire de gite</p>";
        }

        //Verifié que la date d'arrivée n'est pas supérieur à la date départ = une erreur
        if(isset($this->date_depart) > isset($this->date_arrivee)){
            echo "<p class='alert-danger p-2'>ATTENTION : la date d'arrivée est supérieur à la date de part !</p>";
        }

        $sql = "UPDATE gites SET 
                 nom_gite = ?, 
                 description_gite = ?, 
                 img_gite = ?, 
                 nbr_chambre = ?, 
                 nbr_sdb = ?, 
                 zone_geo = ?, 
                 prix_gite = ?, 
                 disponible = ?, 
                 date_arrivee = ?, 
                 date_depart = ?, 
                 gite_categorie = ?, 
                 commentaire_id = ? 
                WHERE id_gite = ?";

        //Recup de la cle primaire dans url via la super globale =_GET['']
        //<a href="details_gite?id_gite=CLE PRIMAIRE DU GITE">Plus d'infos</a>
        $id = $_GET['id_gite'];
        $req = $db->prepare($sql);
        $req->bindParam(1, $this->nom_gite);
        $req->bindParam(2, $this->description_gite);
        $req->bindParam(3, $this->img_gite);
        $req->bindParam(4, $this->nbr_chambre);
        $req->bindParam(5, $this->nbr_sdb);
        $req->bindParam(6, $this->zone_geo);
        $req->bindParam(7, $this->prix);
        $req->bindParam(8, $this->disponible);
        $req->bindParam(9, $this->date_arrivee);
        $req->bindParam(10, $this->date_depart);
        $req->bindParam(11, $this->type_gite);
        $req->bindParam(12, $this->id_commentaire);

        $updateGite = $req->execute(array(
            $this->nom_gite,
            $this->description_gite,
            $this->img_gite,
            $this->nbr_chambre,
            $this->nbr_sdb,
            $this->zone_geo,
            $this->prix,
            $this->disponible,
            $this->date_arrivee,
            $this->date_depart,
            $this->type_gite,
            $this->id_commentaire,
            $id,
        ));

        if($updateGite){
            header("Location: confirmer-maj-gite");
        }else{
            echo "<p class='alert-danger p-2'>Erreur lors de la mise a jour : Merci de verifié et remplir tous les champs !</p>";
        }
    }
}




