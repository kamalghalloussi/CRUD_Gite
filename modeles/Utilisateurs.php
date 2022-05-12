<?php
require_once "modeles/database.php";

class Utilisateurs extends Database
{
    /**
     * @var string
     */
    private $email_user;
    /**
     * @var string
     */
    private $password_user;
    /**
     * @var string
     */
    private $repeatPassword;

    public function inscriptionUtilisateur()
    {

    }

    public function connexionUtilisateur()
    {        
        $db = $this->getPDO();

        if (isset($_SESSION['connecter_user']) && $_SESSION['connecter_user'] === true) {
            ?>
            <h1>Bonjour <?= $_POST['email_user'] ?></h1>
            <?php
        } else {
            echo "<p class='alert-warning mt-2 p-2'>Vous n'ètes âs encore inscrit sur notre site
                    <a href='inscription' class='btn btn-info'>S'incrire</a>
                </p>";
        }


        if (isset($_POST['email_user']) && !empty($_POST['email_user'])) {
            
            $this->email_user = trim(htmlspecialchars($_POST['email_user']));
        } else {
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }
        if (isset($_POST['password_user']) && !empty($_POST['password_user'])) {
            $this->password_user = trim(htmlspecialchars($_POST['password_user']));
        } else {
            echo "<p class='alert-danger p-3'>Merci remplir le champ Email</p>";
        }

        if (!empty($_POST['email_user']) && !empty($_POST['password_user'])) {
            $sql = "SELECT * FROM utilisateur WHERE email = ? AND password = ?";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(1, $this->email_user);
            $stmt->bindParam(2, $this->password_user);

            $stmt->execute();

            if ($stmt->rowCount() >= 1) {
                
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($this->email_user === $row['email'] && $this->password_user === $row['password']) {

                    session_start();
                    
                    $_SESSION['connecter_user'] = true;
                    $_SESSION['email_user'] = $this->email_user;

                    header("Location: accueil");
                } else {

                    echo "<p class='alert-danger p-2'>erreur email et mot passe ne sont pas correct !</p>";
                }
            } else {

                echo "<p class='alert-danger mt-3 p-2'>Aucun utilisateur ne possède cet email et mot de passe</p>";
            }
        } else {

            echo "<p class='alert-danger p-2'>Merci de remplir tous les champs</p>";
        }

        
    }
}