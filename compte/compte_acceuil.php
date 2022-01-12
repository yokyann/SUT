<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- css -->
<link rel="stylesheet" href="./compte_acceuil.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="./planning2.css">
<link rel="stylesheet" href="./fullcalendar/core/main.css">
<link rel="stylesheet" href="./fullcalendar/daygrid/main.css">
<link rel="stylesheet" href="./fullcalendar/timegrid/main.css">
<link rel="stylesheet" href="./fullcalendar/list/main.css">
<!-- css -->


<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>acceuil</title>
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
alert("ERREUR \n veuillez vous inscrire!");
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
$message="<br>Bonjour, $prenom";
}
}
include "./sidebar.php";
}
else{
echo '<script>
alert("ERREUR \nLes identifiants utilisés ne sont pas valides!");
window.location.href = "../inscription&connection/ins_cnx.php";
</script>';
exit(); 
}
?>




<div class="main">
<img src="../page_acceuil/image/bonhomme.png" id="bonhomme" style="max-width:100%;height:auto;">
<div class = "container">
<img src="../page_acceuil/image/bluebubble.png" id="bubble" style="max-width:100%;height:auto;">
<div class="txt">
<b><?php echo $message;?></b>
</div>
</div>

   <div id="calendar"></div>
 
</div>





<script src="./fullcalendar/core/main.js"></script>
<script src="./fullcalendar/daygrid/main.js"></script>
<script src="./fullcalendar/timegrid/main.js"></script>
<script src="./fullcalendar/list/main.js"></script>
<script src="./fullcalendar/interaction/main.js"></script>
<script src="./planning2.js"></script>
</body>
</html>