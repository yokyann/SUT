<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Planning</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <link rel="stylesheet" href="./planning.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script src="./planning.js"></script>

 </head>

 <body>

    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

      include "../bdd_cnx/mysqli_cnx.php";
      session_start();
      @ini_set('display_errors', 'on');
      include "./sidebar.php";
    ?>
  
  <div class="container">
   <div id="calendar"></div>
  </div>
  <?php 
  if($_SESSION['roles'] == 'T'){
      ?>
  <div class="popup">
      <span class="pupTxt" id="pup">
      <div class="liste">
        <div class="liste_etudiant">
        <form action="./planning.php" method="post">
            <button onclick=close() id="x">x</button>
            <?php
                $id_user = $_SESSION['id'];

            echo "<h2> &nbsp; &nbsp; Mes étudiants: </h2></br> ";
            $requete6 = "SELECT id_etudiant FROM etudianttuteur WHERE id_tuteur='$id_user'";
            $result6 = mysqli_query($db, $requete6);

            while ($etu = mysqli_fetch_array($result6, MYSQLI_NUM)) {
                
                $requete7 = "SELECT nom, prenom FROM utilisateur WHERE id_utilisateur='$etu[0]'";
                $result7 = mysqli_query($db, $requete7);
                $row2 = mysqli_fetch_array($result7, MYSQLI_ASSOC);
                $nom = $row2['nom'];
                $prenom = $row2['prenom'];?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" class="check" id="listEtu" name='etus[]' value="<?php echo $etu[0]; ?>"><?php echo "&nbsp;&nbsp;".$prenom . " " . $nom ?></input>
            </br>
            <?php }
            ?>
           
        </div>
        
    </div>
         </br>
    <div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="submit" value="Confirmer"/>
      </div>
      
      </form>
      <?php
      $id_user = $_SESSION['id'];
      if (isset($_POST['submit'])) {
         require '../PHPMailer/src/Exception.php';
         require '../PHPMailer/src/PHPMailer.php';
         require '../PHPMailer/src/SMTP.php';
         $_SESSION['etus']=$_POST['etus'];
        if (!empty($_POST['etus'])) {
            if(count($_POST['etus'])>1){
                echo '<script>
                alert("Veuillez choisir un seul étudiant!");
                window.location.href = "./planning.php";
                </script>';
                exit();
            }else{
            foreach ($_POST['etus'] as $value) {
                $statement0 = mysqli_query($db, "SELECT id FROM events ORDER BY ID DESC LIMIT 1");
                $res0 = mysqli_fetch_array($statement0);
               $id_event=$res0['id'];
               
                $query="UPDATE events SET id_etudiant = '$value' WHERE id='$id_event'";
                $statement= $db->prepare($query);
                $statement->execute();
               } 


               $result = mysqli_query($db, "SELECT email FROM utilisateur WHERE id_utilisateur='$value'");
               $res = mysqli_fetch_array($result);
               $email= $res['email'];
               $mail_body = "
               Bonjour,</br>
               Votre tuteur a fixé la date de votre prochain rendez-vous.</br>
               Veuillez vous connecter pour le vérifier.";
               
               
               $mail = new PHPMailer(True);
               $mail->IsSMTP();      
               $mail->Host = 'smtp.gmail.com';  
               $mail->Port = '465';       
               $mail->SMTPAuth = true;       
               $mail->Username = 'sutnoreply@gmail.com';   
               $mail->Password = 'ProjetEncadre2021';   
               $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     
               $mail->From = 'info@webslesson.info';   
               $mail->FromName = 'SUT';    
               $mail->AddAddress($email, 'Utilisateur');  
               $mail->WordWrap = 50;       
               $mail->IsHTML(true);       
               $mail->Subject = 'Verifiez votre planning'; 
               $mail->Body = $mail_body;      
               if(!($mail->Send()))        
               {
                  
            echo '<script>
                window.location.href = "./planning.php?failtosendemail";
                </script>';
            }
            }
         }
      }
               ?>
      </span>
   </div>
   <?php 
   }
   ?>
 </body>

</html>