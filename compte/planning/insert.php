
<?php
@ini_set('display_errors', 'on');

$db_username = 'root';
$db_password = '';
$db_name = 'sut';
$db_host = 'localhost';
$db = mysqli_connect($db_host, $db_username, $db_password, $db_name)
or die('Connexion impossible à la base de données');
session_start();
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
    $mdp = mysqli_real_escape_string($db, htmlspecialchars($_POST['mdp']));

    if($email !=="" && $mdp!==""){
        $requete = "SELECT id_utilisateur, nom, prenom, roles, user_email_status FROM utilisateur WHERE email = '$email' and mdp = '$mdp'";
        $result = mysqli_query($db, $requete);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count==1) //email et mdp correct
        {
            $id = $row['id_utilisateur'];
            $nom = $row['nom'];
            $role = $row['roles'];
            $prenom = $row['prenom'];
            $user_email_status = $row['user_email_status'];
            $_SESSION['email'] = $nom;
            $_SESSION['prenom']=$prenom;
            $_SESSION['id']=$id;
            $_SESSION['roles']=$role;
            $_SESSION['user_email_status']=$user_email_status;
        }

        
        

    }
}
$connect = new PDO('mysql:host=localhost;dbname=sut', 'root', '');
if(isset($_POST["title"]))
{
if($_SESSION['roles'] == 'T'){
 
 $query = "
 INSERT INTO events 
 (title, start, end, id_tuteur) 
 VALUES (:title, :start_event, :end_event, :id_tuteur)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id_tuteur' => $_SESSION['id']
  )
 );
}else{
    $query = "
 INSERT INTO events 
 (title, start, end, id_etudiant) 
 VALUES (:title, :start_event, :end_event, :id_etudiant)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':id_etudiant' => $_SESSION['id']
  )
 );
}


}
?>