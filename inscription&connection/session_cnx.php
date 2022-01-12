<?php
@ini_set('display_errors', 'on');

session_start();
if (isset($_POST["submit"])) { //set button

    $roles = $_POST["role"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $c_mdp = $_POST["c_mdp"];
    
    include "../bdd_cnx/pdo_cnx.php";
    include "../bdd_cnx/mysqli_cnx.php";
    include "./utilisateur.php";
    
    
    $utilisateur = new Utilisateur($roles, $nom, $prenom, $email, $mdp, $c_mdp);

    $utilisateur->signupUser();
    $utilisateur->sendEmail();
    
}?>
