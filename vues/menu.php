   <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
       
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="accueil">ACCUEIL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rechercher">RECHERCHER</a>
                </li>
                <li class="nav-item">
                    <?php

                    if(isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                        ?>
                        <h4 class="text-danger mt-1"><b style="color: #2c4f56;font-size: 14px">Vous êtes connectez en tant que  :</b> <?= $_SESSION['email_user']  ?></h4>
                        <?php
                    }elseif(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
                        ?>
                        <div class="d-flex">
                            <a class="nav-link" href="administration">ADMINISTRATION</a>
                            <h4 class="text-danger mt-1">
                                <b style="color: #2c4f56;font-size: 14px">Vous êtes connectez en tant que  :</b> <?= $_SESSION['email_admin']  ?>
                            </h4>
                        </div>
                        <?php
                    }else{
                        ?>
                        <a class="nav-link" href="#"></a>
                        <?php
                    }
                    ?>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a class="nav-link btn btn-secondary mr-3" href="inscription">INSCRIPTION</a>
                <?php
                if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true || isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true){
                    ?>
                    <a class="nav-link btn btn-danger" href="deconnexion">DECONNEXION</a>
                    <?php
                }else{
                    ?>
                    <a class="nav-link btn btn-warning" href="connexion">CONNEXION</a>
                    <?php
                }
                ?>
            </form>
        </div>
    </div>
</nav>
