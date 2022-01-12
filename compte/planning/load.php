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

$data = array();
$mon_id=$_SESSION['id'];
if($_SESSION['roles'] == 'E'){
    $query = "SELECT * FROM events WHERE id_etudiant=$mon_id "; //etudiant!!!
}else{
    $query = "SELECT * FROM events WHERE id_tuteur=$mon_id ";
}
$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   =>$row["title"],
  'start'   => $row["start"],
  'end'   => $row["end"]
 );
}

echo json_encode($data);
?>