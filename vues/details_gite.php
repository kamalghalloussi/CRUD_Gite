<?php
require_once "modeles/gites.php";
require_once "modeles/Categories.php";
require_once "modeles/departement.php";
require_once "modeles/commentaires.php";


$giteClasse = new Gites();
$categorieClasse = new Categories();
$regionClasse = new Regions();
$commentaireClasse = new Commentaires();


$details = $giteClasse->getGiteById();
$categories = $categorieClasse->getCategories();
$regions = $regionClasse->getRegions();
$commentaires = $commentaireClasse->getComments();


?>
<div class="text-center">
    <button class="btn btn-success p-3 m-3" id="bntUpdate">METTRE A JOUR LE GITE</button>
</div>


<div class="container-fluid bg-warning mt-3 rounded p-3">



<h1 class="text-center text-danger"><b>DÉTAILS DU GITE</b></h1>
<div id="gite-by-id">
    <h2 class="text-center text-warning"><?= $details['nom_gite'] ?></h2>
    <h3 class="text-center text-info">Type : <?= $details['type_gite'] ?></h3>
    <div class="row mt-5">
        <div class="col-6">
            <img width="100%" class="img-fluid rounded" src="<?= $details['img_gite'] ?>" alt="<?= $details['nom_gite']  ?>" title="<?= $details['nom_gite']  ?>"/>

            <br>
            <?php
            
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

            if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                ?>
                <a href="ajouter_commentaire?id=<?= $details['id_gite'] ?>" class="btn btn-outline-danger mt-2">Ajouter un commentaire</a>
                <a href="reservation?id_gite=<?= $details['id_gite'] ?>" class="btn btn-outline-info mt-2">RESERVER</a>
                <?php
            }else{
                ?>
                <p></p>
                <?php
            }
            ?>
        </div>
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
    </div>
</div>
</div>

<div class="container">
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
        <input type="hidden" name="commentaires" value="1">

        <button type="submit" name="btn-ajouter-gite" class="btn btn-outline-success">Mettre le gite</button>
    </form>

    <?php
    if(isset($_POST['btn-ajouter-gite'])){
        $giteClasse->updateGite();
    }
    ?>
</div>

<?php

?>
<!--ON AFFICHE LES COMMENTAIRES -->
<div class="mt-3 container">
    <h4 class="text-success">COMMENTAIRES</h4>
    <ul class="list-group">
        <?php
        foreach ($commentaires as $alias) {

                ?>

                <li class="list-group-item">
                <li class="list-group-item">Nom de l'auteur : <b
                            class="text-info"><?= $alias['auteur_commentaire'] ?></b></li>
                <li class="list-group-item">Commentaire de l'auteur : <b
                            class="text-info"><?= $alias['contenu_commentaire'] ?></b></li>

                <?php

        }
        ?>
    </ul>
</div>


<script>
    /////////////////////////////UPDATE FORM TOGGLE///////////////////
    //Au clic sur le bouton update : on passe du formulaire au details du gites


    let btnUpdateGite = document.getElementById("bntUpdate");
    let updateForm = document.getElementById("update-form");
    let blockGiteID = document.getElementById("gite-by-id");

    btnUpdateGite.addEventListener("click", () => {
        console.log("test de click");
        updateForm.classList.toggle("show");
        blockGiteID.classList.toggle("show");

        //element.classList.contains(className);

        //Si le formulaire possède la classe css .show
        //On change la couleur du bouton + le texte
        //Sinon l'inverse

        if (updateForm.classList.contains("show")) {
            btnUpdateGite.style.backgroundColor = "#789456";
            btnUpdateGite.style.border = "none";
            btnUpdateGite.innerHTML = "AFFICHER LE DETAILS";
        } else {
            btnUpdateGite.style.backgroundColor = "orange"
            btnUpdateGite.innerHTML = "AFFICHER LE FORMULAIRE";
            btnUpdateGite.style.border = "none";
        }
    })
</script>




