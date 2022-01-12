<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./compte_etudiant_tuteur.css">
    <script src="./cours_tuteur.js"></script>
    <title>UEs</title>
</head>

<body class="main">

    <?php

    @ini_set('display_errors', 'on');
    include "../bdd_cnx/mysqli_cnx.php";
    session_start();
    include "./sidebar.php";

    // la liste des UE dispo
    $user = $_SESSION['email'];
    $prenom =  $_SESSION['prenom'];

    $stmt = "SELECT * FROM ue";
    $result = mysqli_query($db, $stmt);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC); ?>
    <section>
        <div class="cours">
            <h1><img src="../page_acceuil/image/lisant-un-livre.png" alt="" style="max-width:100%;height:auto;"> Mes cours</h1>
            <!--<p>Dans cette rubrique tu peux choisir les cours qui t'interesses afin de partager tes connaissance avec nos étudiants.</p>-->
        </div>
        <div class="liste">
            <div class="liste_ue">

                <h1>&nbsp;&nbsp; UEs disponibles </h1>&nbsp;&nbsp;&nbsp;&nbsp;<i>Veuillez sélectionner une seule UE:</i></br></br>

                <form action="./cours_tuteur.php" class="ue-form" method="post">
                    <?php

                    foreach ($res as $row) { ?>
                        <div>
                            <?php
                            $id = $row['id_ue'];

                            ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="check" id="listUE" name='ids[]' value="<?php echo $id; ?>"><?php echo '&nbsp;'.$row["nom_ue"] ?></input>
                        </div>
                    <?php
                    }
                    ?>
                    <br>
                    <div class="boutons">
                        <input type="submit" name="submit" class="btn" value="Confirmer" />
                    </div>
                </form>
            </div>

        </div>
        </div>

    </section>



    <?php
    // insertion de l'UE choisis dans la bdd
    $id_user = $_SESSION['id'];
    if (isset($_POST['submit'])) {

        if (!empty($_POST['ids'])) {

            foreach ($_POST['ids'] as $value) {
                $insertion = true;
                $result = mysqli_query($db, "SELECT id_utilisateur FROM utilisateurue WHERE id_utilisateur=$id_user ");
                if (mysqli_num_rows($result) == 0) {
                    $in_ch = mysqli_query($db, "INSERT INTO utilisateurue(id_utilisateur,id_ue) VALUES ('$id_user','$value')");
                } else {
                    $insertion = FALSE;
                    echo '<script>
                alert("Vous avez déjà choisi une UE");
                window.location.href = "./cours_tuteur.php";
                </script>';
                    exit();
                }
            }
            if ($insertion == true) {
                echo '<script>
            alert("Votre choix a été pris en compte");
            window.location.href = "./cours_tuteur.php";
            </script>';
                exit();
            } else {
                echo '<script>
            alert("Échec");
            window.location.href = "./cours_tuteur.php";
            </script>';
                exit();
            }
        }
    } ?>
    <!-- l'affichage des ues choisies-->
    <div class="liste">
        <div class="liste_ue">
            <form action="./cours_tuteur.php" class="ue-form" method="post">
                <?php
                echo "<h2>&nbsp;&nbsp; Mon UE: </h2></br> ";
                $requete1 = "SELECT id_ue FROM utilisateurue WHERE id_utilisateur='$id_user'";
                $result1 = mysqli_query($db, $requete1);
                while ($ues = mysqli_fetch_array($result1)) {
                    $requete2 = "SELECT nom_ue, id_ue FROM ue WHERE id_ue='$ues[0]'";
                    $result2 = mysqli_query($db, $requete2);
                    $row2 = mysqli_fetch_array($result2);
                    $nom = $row2['nom_ue'];
                ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="check" id="monUE" name='idue' value="<?php echo $row2['id_ue']; ?>"><?php echo '&nbsp;'.$nom ?></input>

                <?php }
                ?>

                <br>
                <div class="boutons">
                <input type="submit" name="submit2" class="btn" value="Supprimer" />
                </div>

            </form>
        </div>
    </div>
    
    <!-- Affiche la liste des étudiants associé-->
    <div class="liste">
        <div class="liste_etudiant">
            <?php
                $id_user = $_SESSION['id'];

            echo "<h2>&nbsp;&nbsp; Mes étudiants: </h2></br> ";
            $requete6 = "SELECT id_etudiant FROM etudianttuteur WHERE id_tuteur='$id_user'";
            $result6 = mysqli_query($db, $requete6);

            while ($etu = mysqli_fetch_array($result6, MYSQLI_NUM)) {
                
                $requete7 = "SELECT nom, prenom FROM utilisateur WHERE id_utilisateur='$etu[0]'";
                $result7 = mysqli_query($db, $requete7);
                $row2 = mysqli_fetch_array($result7, MYSQLI_ASSOC);
                $nom = $row2['nom'];
                $prenom = $row2['prenom'];
                echo '&nbsp;&nbsp;- ' . $prenom . " " . $nom . '</br>';
            }
            ?>
        </div>
    </div>

    <?php
    // suppression des ue selectionnées
    $id_user = $_SESSION['id'];
    
    if (isset($_POST['submit2'])) {

        if (isset($_POST['idue'])) {
            $chr = $_POST['idue'];
            $requete10 = "SELECT id_etudiant FROM etudianttuteur WHERE id_tuteur='$id_user'";
            $result10 = mysqli_query($db, $requete10);
            while ($etu = mysqli_fetch_array($result10, MYSQLI_NUM)) {
                
                $result3 = mysqli_query($db, "DELETE FROM utilisateurue WHERE id_utilisateur='$etu[0]' AND id_ue='$chr'");
                $result4 = mysqli_query($db, "DELETE FROM etudianttuteur WHERE id_etudiant='$etu[0]' AND id_tuteur='$id_user'");
                
                
            }
            $res = mysqli_query($db, "DELETE FROM utilisateurue WHERE id_utilisateur='$id_user' AND id_ue='$chr'");

            echo '<script>
                alert("Vos modifications ont été prise en compte");
                window.location.href = "./cours_tuteur.php";
                </script>';
                exit();
            
        }
    }


    ?>
<br>

</body>

</html>