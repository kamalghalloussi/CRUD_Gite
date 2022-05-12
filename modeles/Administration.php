<?php

require_once "modeles/Database.php";

class Administration extends Database
{
    //Les propriétées = variables dans une classe
    //POUR LES ADMINS
    /**
     * @var string
     */
    private $email_admin;
    /**
     * @var string
     */
    private $password_admin;

    public function connexionAdmin(){
        
        $db = $this->getPDO();

        if(isset($_POST['email_admin']) && !empty($_POST['email_admin'])){
          
            $this->email_admin = trim(htmlspecialchars(strip_tags($_POST['email_admin'])));
        }else{
            echo "<p class='alert-danger p-3 mt-3'>Merci remplir le champ Email</p>";
        }

        if(isset($_POST['password_admin']) && !empty($_POST['password_admin'])){
            $this->password_admin = trim(htmlspecialchars(strip_tags($_POST['password_admin'])));
        }else{
            echo "<p class='alert-danger p-3 mt-3'>Merci remplir le champ Email</p>";
        }

        if(!empty($_POST['email_admin']) && !empty($_POST['password_admin'])){
            $sql = "SELECT * FROM administrateurs WHERE email_admin = ? AND password_admin = ?";

            $stmt = $db->prepare($sql);

            $stmt->bindParam(1, $this->email_admin);
            $stmt->bindParam(2, $this->password_admin);
          
            $stmt->execute();
            
            if($stmt->rowCount() >= 1){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($this->email_admin === $row['email_admin'] && $this->password_admin === $row['password_admin']){
                    session_start();
                    $_SESSION['connecter'] = true;
                    $_SESSION['email_admin'] = $this->email_admin;
                    header('Location: administration');
                }else{
                    echo "<p class='alert-danger mt-3 p-2'>Erreur de connexion, merci de verifié votre email et mot de passe et recommencer !</p>";
                }
            }else{
                echo "<p class='alert-danger mt-3 p-2'>Erreur de connexion, merci de verifié votre email et mot de passe !</p>";
            }
        }else{
            echo "<p class='alert-danger mt-3 p-2'>Merci de remplir tous les champs</p>";
        }
    }
}