<?php

include('../bdd_cnx/database_connection.php');

$message = '';

if(isset($_GET['activation_code']))
{
 $query = "
  SELECT * FROM utilisateur 
  WHERE user_activation_code = :user_activation_code
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':user_activation_code'   => $_GET['activation_code']
  )
 );
 $no_of_row = $statement->rowCount();
 
 if($no_of_row > 0)
 {
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   if($row['user_email_status'] == 'not verified')
   {
    $update_query = "
    UPDATE utilisateur
    SET user_email_status = 'verified' 
    WHERE id_utilisateur = '".$row['id_utilisateur']."'
    ";
    $statement = $connect->prepare($update_query);
    $statement->execute();
    $sub_result = $statement->fetchAll();
    if(isset($sub_result))
    {
     $message = '<label class="text-success">Votre adresse mail a été <br> verifiée avec succès <br><br> Vous pouvez <br> vous connecter <a href="./ins_cnx.php">ici</a></label>';
    }
   }
   else
   {
    $message = '<label class="text-info">Votre adresse mail <br> a déjà été vérifiée</label>';
   }
  }
 }
 else
 {
  $message = '<label class="text-danger">Lien invalide</label>';
 }
}

?>
<!DOCTYPE html>
<html lang="fr">
<html>
 <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verification</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./merci_cnx.css" />
 </head>
 <body>

   <div><img src="../page_acceuil/image/bonhomme.png" id="bonhomme" style="max-width:100%;height:auto;"></div>
    <div class ="container">
        <img src="../page_acceuil/image/bubble.png" id="bubble" style="max-width:100%;height:auto;">
        <div class="txt">
            <?php 
            echo $message; 
            ?>
        </div>
    </div>
 
 </body>
 
</html>

