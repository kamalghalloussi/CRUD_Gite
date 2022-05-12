<?php
//Appel de la classe Commentaires
require_once "modeles/commentaires.php";
$commentaireClasse = new Commentaires();
?>


<div class="container">
    <form method="post">
        <h4 class="text-success">Ajouter un commentaire</h4>
        <?php
            $email = $_SESSION['email_user'];
            $id = $_GET['id'];
        ?>
        <div class="mb-3">
            <input type="email" value="<?= $email ?>" class="form-control"  name="auteur_commentaire" placeholder="<?= $email ?>">
        </div>

        <div class="form-group">
            <label for="contenu_commentaire">Votre commentaire : </label>
            <textarea class="form-control" id="contenu_commentaire" name="contenu_commentaire" rows="5"></textarea>
        </div>

        <!--Ce champ est caché et prend par defaut ID du gite concerner par ajout du commentaire-->
        <div class="mb-3">
            <input type="hidden" name="gites_id" value="<?= $id ?>">
        </div>

        <button type="submit" name="btn-add-comment" class="btn btn-outline-success">Ajouter un commentaire</button>

    </form>
</div>

<?php
if(isset($_POST['btn-add-comment'])){
    $commentaireClasse->addComments();
}
