<div class="texte-center">
    <div >
            <h1>
                LES GITES EN LOCATION 
            </h1>							
    </div>
</div>        
        


<?php

require_once "modeles/gites.php";

$giteClasse= new Gites(); 

$gites = $giteClasse->affichergites();





?>
<div class="packages-content">


				<div class="row">

					<?php
foreach ($gites as $GITE) {
    ?>
    <div class="col-md-4 col-sm-6">
						<div class="single-package-item">
							<img src="<?= $GITE ['img_gite'] ?>" alt="package-place">
							<div class="single-package-item-txt">
                                <?php
                                if ($GITE['disponible'] == 1  )
                                        
                                    {$dispo="disponible";}
                                    else {$dispo="pas disponible";}
                                ?>
     
                                
								<h3><?= $GITE ['nom_gite'] ?>  <span class="pull-right"><?= $GITE ['prix_gite'] ?> €</span></h3>
								<div class="packages-para">

										<i class="fa fa-angle-right"></i> Nombre de salle de bain : <?= $GITE ['nbr_sdb'] ?> 
                                        <br>
                                        <i class="fa fa-angle-right"></i> Disponibilité : <?= $dispo ?>  
                                        <br>
                                       <i class="fa fa-angle-right"></i> Localisation : <?= $GITE ['departement_nom'] ?> 
                                        <br>
                                         <br>
								    <i class="fa fa-angle-right"></i> Description : <?= $GITE ['description_gite'] ?>  

                                </div>

								<div class="about-btn">
									<button class="about-view packages-btn">
										Réservez
									</button>
								</div>
								<!--/.about-btn-->
							</div>
						</div>

					</div>
                    <?php
}

                    ?>
				

				</div>
				<!--/.row-->
			</div>