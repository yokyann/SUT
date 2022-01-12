<?php
@ini_set('display_errors', 'on');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    

class Utilisateur extends Dbh
{
    private $roles;
    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $c_mdp;
    private $user_activation_code;
    private $user_email_status;

    public function __construct($roles, $nom, $prenom, $email, $mdp, $c_mdp)
    {
        $this->roles = $roles;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->c_mdp = $c_mdp;
        $this->user_activation_code = md5(rand());
    }

    //Entre les données de l'utilisateur dans la base
    public function setUser($roles, $nom, $prenom, $email, $mdp, $user_activation_code)
    {
        $stmt = $this->connect()->prepare("INSERT INTO utilisateur(roles, nom, prenom, email, mdp, user_activation_code) VALUES(?,?,?,?,?,?);");

        //$cacheMdp = password_hash($mdp, PASSWORD_DEFAULT);
        $stmt->execute(array($roles, $nom, $prenom, $email, $mdp, $user_activation_code));
        $stmt1 = $this->connect()->prepare("SET GLOBAL event_scheduler = ON");
        $stmt1->execute();
        $stmt2 = $this->connect()->prepare("CREATE EVENT IF NOT EXISTS del".$user_activation_code." ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR DO DELETE FROM utilisateur WHERE email='".$email."' AND user_email_status='not verified'");
        $stmt2->execute();
    }

    public function loginUser($email, $mdp){
        $b = $this->checkUser($this->email);
        if(!$b){
            header("location: ./ins_cnx.php?error=REGISTERFIRST");
        }
        else{
            $stmt = $this->connect()->prepare("SELECT mdp FROM utilisateur WHERE email = '$email'");
            echo $stmt;
        }
        
    }

    //Regarde si l'email existe déja dans la base de donnée
    public function checkUser($email)
    {
        $resultCheck=true;
        $stmt = $this->connect()->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $res = $stmt->rowCount();
        if ($res>0) {
            $resultCheck = false;
        }
    
        return $resultCheck;
    }



    //Vérifie la bonne syntaxe des données
    public function signupUser(){
        //input vide 

        $bool = $this->emptyInput();
        if ($bool == false) {
            echo '<script>
            alert("ERREUR \nChamp vide !");
            window.location.href = "./ins_cnx.php";
            </script>';
            exit();
        }
        
        $bool = $this->invalidNom();
        //Caractère spéciaux ?
        if ($bool == false) {
            echo '<script>
            alert("ERREUR \nLe nom ne doit pas contenir des caractères spéciaux !");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('./index.php');
            exit(); 

        }
        //Caractère spéciaux ?
        $bool = $this->invalidPrenom();
        if ($bool == false) {
            echo '<script>
            alert("ERREUR \nLe prénom ne doit pas contenir des caractères spéciaux !");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('./ins_cnx.php');
            exit(); 
        }
        //Syntaxe du mail
        
        if ($this->invalidEmail() == false) {
            echo '<script>
            alert("ERREUR \nVeuillez utiliser votre adresse de messagerie fournie par Sorbonne Université");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('ins_cnx.php');
            exit();
        }

        //mdp sécurisé
        if($this->invalidMdp() == false){
            echo '<script>
            alert("ERREUR \nVotre mot de passe doit contenir au minimum 8 caractères, y compris une majuscule, une minuscule, un chiffre, et un caractère spécial");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('index.php');
            exit();
        }

        
        //Mail déjà existant?
        $bool = $this->userExist();
        if ($bool == false) {
            echo '<script>
            alert("ERREUR \nEmail déjà utilisé !");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('./ins_cnx.php');
            exit(); 
        }
        //confirmation mdp
        $bool = $this->confirmerMDP();
        if ($bool == false) {
            echo '<script>
            alert("ERREUR \nLe mot de passe ne correspond pas !");
            window.location.href = "./ins_cnx.php";
            </script>';
            include('./ins_cnx.php');
            exit(); 
        }
        //Rentre les données dans la base
        $this->setUser($this->roles, $this->nom, $this->prenom, $this->email, $this->mdp, $this->user_activation_code);
        
        
    }
    private function invalidMdp(){
        $result=true;
        $majuscule= preg_match('@[A-Z]@', $this->mdp);
        $minuscule= preg_match('@[a-z]@', $this->mdp);
        $nombre= preg_match('@[0-9]@', $this->mdp);
        $specialChar= preg_match('@[^\w]@', $this->mdp);
        $longueur = strlen($this->mdp)<8;
        if(!$majuscule || !$minuscule || !$nombre || !$specialChar || $longueur){
            $result=false;
        }
        return $result;
    }
    public function sendEmail(){
        $base_url = "http://localhost/SUT/inscription&connection/";
        $mail_body = "
        <p>Bonjour ".$this->prenom.",</p>
        <p>Merci de votre inscription sur le site de tutorat de Sorbonne Université! <br><br>
        Votre compte a été créé. Veuillez cliquer sue le lien ci-dessous pour l'activer.<br>
        Attention, ce lien n'est valide que pour 1 heure.<br>
        ".$base_url."email_verif.php?activation_code=".$this->user_activation_code."
        ";
        
        
        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        $mail = new PHPMailer(True);
        $mail->IsSMTP();        //Envoi du message avec SMTP
        $mail->Host = 'smtp.gmail.com'; 
        $mail->Port = '465';       
        $mail->SMTPAuth = true;     
        $mail->Username = 'sutnoreply@gmail.com';     
        $mail->Password = 'ProjetEncadre2021';     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     
        $mail->From = 'info@webslesson.info';  
        $mail->FromName = 'SUT';     
        $mail->AddAddress($this->email, $this->prenom);   
        $mail->WordWrap = 50;      
        $mail->IsHTML(true);      
        $mail->Subject = 'Email Verification';   
        $mail->Body = $mail_body;      
        if($mail->Send())       
        {
            header("location:./merci_cnx.php");
    }
}

    private function emptyInput(){
        $result=true;
        if(empty($this->nom) || empty($this->prenom) || empty($this->email) || empty($this->mdp) || empty($this->c_mdp)){
            $result = false;
        }
        return $result;
    }

    private function invalidNom(){
        $result=true;
        if(!preg_match("/^([a-zA-Z' ]+)$/", $this->nom))
        {
            $result = false;
        }
        return $result;
    }

    private function invalidPrenom(){
        $result=true;
        if(!preg_match("/^([a-zA-Z' ]+)$/", $this->prenom))
        {
            $result = false;
        }
        return $result;
    }

    private function invalidEmail(){
        $valide = false;
        $domaine_valide="gmail.com";
        $longueur = strlen($domaine_valide);
        $domaine_utilisateur=strtolower(substr($this->email, -($longueur), $longueur));
        if($domaine_utilisateur==$domaine_valide){
            $valide=true;
        }
        return $valide;
    }

    private function confirmerMDP(){
        $result=true; 
        if($this->mdp !== $this->c_mdp){
            $result = false;
        }
        return $result;
    }

    private function userExist(){
        $result=true; 
        if(!$this->checkUser($this->email)){
            $result = false;
        }
        return $result;
    }
}
