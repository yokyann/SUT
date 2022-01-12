<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./compte_acceuil.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>menu</title>
</head>
<body>
<?php
@ini_set('display_errors', 'on');
include "../bdd_cnx/mysqli_cnx.php";
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

if(isset($_SESSION['id'])){
$id_user=$_SESSION['id'];

$query=mysqli_query($db,"SELECT id_utilisateur FROM utilisateur WHERE id_utilisateur='$id_user'");

if(mysqli_num_rows($query)==0){
echo '<script>
alert("ERREUR \n veuillez vous inscrir!");
window.location.href = "../inscription&connection/ins_cnx.php";
</script>';
        exit(); 
}
else{


if($_SESSION['user_email_status'] != 'verified'){
    echo '<script>
    alert("ERREUR \nLes identifiants utilisés ne sont pas valides!");
    window.location.href = "../inscription&connection/ins_cnx.php";
    </script>';
        exit(); 
}
if(isset($_GET['deconnexion'])){
    if($_GET['deconnexion']==true){
        session_unset();
        header("location:../inscription&connection/ins_cnx.php");
    }
}
if(($_SESSION['email'] !== "") && ($_SESSION['prenom'] !== "")){
    $user = $_SESSION['email'];
    $prenom =  $_SESSION['prenom'];
    $message="<br>Bonjour, $prenom ,$id_user";
}

}}
else{
    echo '<script>
    alert("ERREUR \nLes identifiants utilisés ne sont pas valides!");
    window.location.href = "../inscription&connection/ins_cnx.php";
    </script>';
        exit(); 
}
?>

<div class="sidebar">
<div class="logo-details">
    
    <div class="logo_name">SUT</div>
    <i class='bx bx-menu' id="btn" ></i>
</div>
<ul class="nav-list">
    <li>
        <i class='bx bx-search' ></i>
        <input type="text" placeholder="Recherche..">
        <span class="tooltip">Recherche</span>
    </li>
    <li>
    <a href="./compte_acceuil.php">
        <i class='bx bx-grid-alt'></i>
        <span class="links_name">Accueil</span>
    </a>
        <span class="tooltip">Accueil</span>
    </li>

    <li>
    <?php 
    if ($_SESSION['roles']=='E'){ 
        echo '<a href="./cours_etudiant.php">';
    }
    if ($_SESSION['roles']=='T'){ 
        echo '<a href="./cours_tuteur.php">';
        }
        
        ?>
    
    <i class='bx bxs-book'></i>
        <span class="links_name">UE</span>
    </a>
    <span class="tooltip">UE</span>
    </li>
    <li>
    <a href="./compte_param.php">
        <i class='bx bx-user' ></i>
    <span class="links_name">Compte</span>
    </a>
    <span class="tooltip">Compte</span>
    </li>
    
    
    <li>
    <a href="../planning/planning.php">
    <i class='bx bx-calendar'></i>
        <span class="links_name">Planning</span>
    </a>
    <span class="tooltip">Planning</span>
    </li>
    <li>
    <a href="#">
        <i class='bx bx-cog' ></i>
        <span class="links_name">Paramètres</span>
    </a>
    <span class="tooltip">Paramètres</span>
    </li>
<li>
        <a href="compte_acceuil.php?deconnexion=true">
        <i class='bx bx-log-out' id="log_out" ></i>
        <span class="links_name">Déconnexion</span>
    </a>
        <span class="tooltip">Déconnexion</span>
    </li>
</ul>
</div>



<script src="./compte_Acceuil.js"></script>



</body>
</html>