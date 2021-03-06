<?php

// Appel du fichier Gites classe
require_once  "backend/Gites.php";
require_once "backend/Categorie.php";
require_once "backend/Region.php";


//Instance = copie de la classe stockee dans une variable
$giteClasse = new Gites();
$categorieClasse = new Categorie();
$regionClasse = new Region();

//Appel de la methode getGiteById() pour appeler un gite
$details = $giteClasse->getGiteById();

$categories = $categorieClasse->getCategorie();
$regions = $regionClasse->getRegion();

?>


<div class="container-fluid bg-warning mt-3 rounded p-3">

    <h1 class="text-center text-danger"><b>DÉTAILS DU GITE</b></h1>
    <div id="gite-by-id">

        <?php
        echo $details['nom_gite'];
        echo $details['description_gite'];
        echo $details['image_gite'];
        ?>
    </div>
</div>

<?php
//On demarre la session
//si session connecter retourne la page d'accueil
if(isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    ?>
    <a href="administration" class="btn btn-danger mt-3">RETOUR</a>
    <form method="post" class="mt-3">
        <button name="bnt-delete-gite" class="btn btn-success">Supprimer le gite</button>
        <a href="accueil" class="btn btn-danger mt-2">RETOUR</a>
    </form>

<?php
    if(isset($_POST['bnt-delete-gite'])){
        var_dump("test de clic");
        $giteClasse->deleteGite();
    }
}

//Si utilisateur est connecté on peu ajouter un commentaire
if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
?>
<a href="ajouter_commentaires?id_commentaire=<?= $details['id_gite'] ?>" class="btn btn-outline-danger mt-2">Ajouter un commentaire</a>
<a href="reservation?id_gite=<?= $details['id_gite'] ?>" class="btn btn-outline-info mt-2">RESERVER</a>
<?php
}
//On demarre la session
//si session connecter retourne la page d'accueil
if(isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    ?>
    <a href="administration" class="btn btn-danger mt-3">RETOUR</a>
    <form method="post" class="mt-3">
        <button name="bnt-delete-gite" class="btn btn-success">Supprimer le gite</button>
    </form>

    <?php
    if(isset($_POST['bnt-delete-gite'])){
        var_dump("test de clic");
        $giteClasse->deleteGite();
    }
}else{
    ?>
    <a href="accueil" class="btn btn-danger mt-2">RETOUR</a>
    <?php

}

//Si utilisateur est connecté on peu ajouter un commentaire
if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
    ?>
    <a href="ajouter_commentaire?id=<?= $details['id_gite'] ?>" class="btn btn-outline-danger mt-2">Ajouter un commentaire</a>
    <a href="reservation?id_gite=<?= $details['id_gite'] ?>" class="btn btn-outline-info mt-2">RESERVER</a>
    <?php
}
?>

<div class="col-6">
    <p class="card-text"><b>Description : </b></p>
    <p><?= $details['description_gite'] ?></p>
    <p><b>Nombre de salle de bains : </b><b class="text-danger"><?= $details['nbr_sdb'] ?></b></p>
    <p><b>Zone géographique : </b><b class="text-info"><?= $details['zone_geo'] ?></b></p>
    <p><b>Prix à la semaine : </b><b class="text-success"><?= $details['prix_gite'] ?> €</b></p>

    <?php
    $dispo = $details['disponible'];
    if($dispo == false){
        echo $dispo =  "NON";
    }else{
        echo  $dispo = "OUI";
    }
    ?>

    <p><b>Disponible : </b><b class="text-warning"><?= $dispo ?></b></p>
    <?php
    $date_a = new DateTime($details['date_arrivee']);
    $date_d = new DateTime($details['date_depart']);
    ?>
    <p><b>Date debut de la dernière location : </b> </p>
    <p class="alert-success p-2"><?=  $date_a->format('d-m-Y')?></p>

    <p><b>Date du dernier depart : </b></p>
    <p class="alert-info p-2"> <?=  $date_d->format('d-m-Y')?></p>
</div>


<div class="container">
    <!--La methode post recup les trriburs name de chaque elements du formulaire a l'aide de la super globale $_POST['name=nom_gite']-->
    <form method="post" enctype="multipart/form-data">
        <div class="mt-3">
            <label for="nom_gite">Nom du gite</label>
            <input type="text" id="nom_gite" name="nom_gite" class="form-control" placeholder="<?= $details['nom_gite'] ?>" value="<?= $details['nom_gite'] ?>" required>
        </div>

        <div class="mt-3">
            <label for="description_gite">Description du gite</label>
            <textarea type="text" id="description_gite" name="description_gite" class="form-control" value="<?= $details['description_gite'] ?>">
                    <?= $details['description_gite'] ?>
            </textarea>
        </div>

        <div class="form-group">
            <label for="img_gite">Image du gite : </label>
            <br />
            <input class="btn btn-outline-success" type="file" id="img_gite" name="img_gite" accept="image/png, image/jpeg, image/webp image/bmp, image/svg">
        </div>

        <div class="mt-3">
            <label for="nbr_chambres">Choix du nombre de chambre
                <select name="nbr_chambre" class="form-control">
                    <option selected>Nombre de chambre</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </label>
        </div>

        <div class="mt-3">
            <label for="nbr_sdb">Choix du nombre de salle de bains
                <select name="nbr_sdb" class="form-control">
                    <option selected>Nombre de salle de bains</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </label>
        </div>

        <div class="mt-3">
            <label for="regions">Choix de la region
                <select name="zone_geo" class="form-control">
                    <?php
                    foreach ($regions as $region){
                        ?>
                        <option value="<?= $region['departement_id'] ?>"><?= $region['departement_nom'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </label>
        </div>

        <div class="mt-3">
            <label for="categories">Choix de la  catégorie
                <select name="type_gite" class="form-control">
                    <?php
                    foreach ($categories  as $category){
                        ?>
                        <option value="<?= $category['id_categorie'] ?>">
                            <?= $category['type_gite'] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label for="prix">Prix / semaine : </label>
            <input type="number" step="0.01" class="form-control" id="prix" name="prix_gite" placeholder="<?= $details['prix_gite'] ?>" value="<?= $details['prix_gite'] ?>">
        </div>

        <div class="mt-3">
            <label for="disponible">Est disponible
                <select name="disponible" class="form-control">
                    <option value="0">NON</option>
                    <option value="1">OUI</option>
                </select>
            </label>
        </div>

        <div class="form-group">
            <label for="date_arrivee">Date de depot de l'offre : </label>
            <input type="date" id="date_arrivee" name="date_arrivee" placeholder="<?= $details['date_arrivee'] ?>" value="<?= $details['date_arrivee'] ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="date_depart">Date de depart</label>
            <input type="date" class="form-control" name="date_depart" id="date_depart" placeholder="<?= $details['date_depart'] ?>" value="<?= $details['date_depart'] ?>" required>
        </div>
        <!--Ce champs est caché Admin na pas renseigner de commentaire ou le mettre a jour sur le gite sa valeur par defaut est 1-->
        <input type="hidden" name="commentaires" value="1">

        <button type="submit" name="btn-ajouter-gite" class="btn btn-outline-success">Mettre le gite</button>
    </form>

    <?php
    if(isset($_POST['btn-ajouter-gite'])) {
        //Appel de la methode updateGite de la classe Gites.php
        $giteClasse->updateGite();
    }
    ?>
</div>

