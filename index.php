<?php
session_start();
?>

<?php

ob_start();
?>

<?php


if(isset($_GET['url'])){
    $url = $_GET['url'];
}else{
    $url = "accueil";
}

if($url === ""){
    $url = "accueil";
}

if($url === "accueil"){
    require_once "vues/accueil.php";
}elseif ($url === "connexion"){
    require_once "vues/connexion.php";
}elseif ($url === "404"){
    require_once "vues/404.php";
}elseif ($url === "page"){
    require_once "vues/page.php";
}elseif($url === "deconnexion"){
    require_once "vues/deconnexion.php";
}

elseif ($url === "administration" ) {
    require_once "vues/administration.php";
    
} elseif($url === "details_gite" && isset($_GET['id_gite']) && $_GET['id_gite'] > 0){
    require_once "vues/details_gite.php";

}elseif($url === "ajouter-gite" && isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    require_once "vues/ajouter-gite.php";

}elseif ($url === "confirmer-ajout-gite" && isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    require_once "vues/confirmer-ajout-gite.php";

}elseif($url === "supprimer-gite" && isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    require_once "vues/supprimer-gite.php";

}elseif($url === "confirmer-maj-gite" && isset($_SESSION['connecter_admin']) && $_SESSION['connecter_admin'] === true){
    require_once "vues/confirmer-maj-gite.php";

}

elseif($url === "inscription"){
    require_once "vues/inscription.php";
}elseif($url === "ajouter_commentaire" && isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
    require_once "vues/ajouter_commentaire.php";
}
elseif($url === "inscription"){
    require_once "vues/inscription.php";
}

elseif($url !=  '#:[\w]+)#'){
    header("Location: accueil");

}

$auto=ob_get_clean();

require_once "template.php";

?>

