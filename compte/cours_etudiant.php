<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./compte_etudiant_tuteur.css">
    <title>UEs</title>
</head>

<body class="main">

    <?php
    @ini_set('display_errors', 'on');
    include "../bdd_cnx/mysqli_cnx.php";
    session_start();
    include "./sidebar.php";

    $user = $_SESSION['email'];
    $prenom =  $_SESSION['prenom'];



    $stmt = "SELECT * FROM ue";
    $result = mysqli_query($db, $stmt);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    
    $id_user = $_SESSION['id'];
    ?>

    <section>
        <!-- Affiche la liste des ue dispo -->
        <div class="cours">
            <h1><img src="../page_acceuil/image/lisant-un-livre.png" alt=""> Mes cours</h1>
            <!--<p>Dans cette rubrique tu peux choisir les cours qui t'interesses afin de partager tes connaissance avec nos étudiants.</p>-->
        </div>
        <div class="liste">
            <div class="liste_ue">

                <h1>&nbsp;&nbsp; UE's disponibles:</h1></br>


                <form action="./cours_etudiant.php" class="ue-form" method="post">
                    <?php

                    foreach ($res as $row) { ?>
                        <div>
                            <?php
                            $id = $row['id_ue'];
                            //echo $id;
                            ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="check" id="listUE" name='ids[]' value="<?php echo $id; ?>"><?php echo '&nbsp;' . $row["nom_ue"] ?></input>
                        </div>
                    <?php
                    }
                    ?>
                    
                    <div>

                    </div>

            </div>
            

        </div>
        </div>


    </section>

    <?php
    //Affiche la liste des tuteurs + les ues qui lui est associé
    $stmt = "SELECT * FROM utilisateur where roles='T'";
    $result = mysqli_query($db, $stmt);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    <div class="liste">
        <!-- LISTE TUTEURS -->
        <div class="liste_tuteur">

            <?php
            echo '<h2>&nbsp;&nbsp; Liste des Tuteurs: </h2><br>';
            foreach ($res as $row) {
                $id_tuteur = $row['id_utilisateur']; 
                ?>
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="listtut" name='tut[]' value="<?php echo $id_tuteur; ?>"><a href="./NEW/index.php?id=<?php echo $id_tuteur?>"> <?php echo '&nbsp;'.$row["nom"]." ".$row['prenom'] ?></a></input> 
                <?php
                $stmt2 = "SELECT * FROM utilisateurue where id_utilisateur='$id_tuteur'";
                $result2 = mysqli_query($db, $stmt2);
                $res2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                //LISTE DE SES UES
                foreach ($res2 as $row) {
                    $id_ue = $row['id_ue'];

                    $stmt3 = "SELECT * FROM ue where id_ue='$id_ue'";
                    $result3 = mysqli_query($db, $stmt3);
                    $res3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);
                    foreach ($res3 as $row) {
                        $nom_ue = $row['nom_ue'];
                        ?> <i> <?php echo " : " . $nom_ue; ?> </i>
                        </br>
                        
            <?php
                    }
                }
            }
            
            ?>
            <br>
            <div class="boutons">
                <input type="submit" name="SetTuteur" class="btn" id="bouton" value="Ajouter" />
            </div>

            </form>
        </div>
    </div>

    <!-- Afiiche la liste des UES sélectionnées -->
    <div class="liste">
        <div class="liste_ue">
            <form action="./cours_etudiant.php" class="ue-form" method="post">
                <?php
                echo "<h2>&nbsp;&nbsp; Mes UE's: </h2></br> ";
                $requete1 = "SELECT id_ue FROM utilisateurue WHERE id_utilisateur='$id_user'";
                $result1 = mysqli_query($db, $requete1);
                while ($ues = mysqli_fetch_array($result1)) {
                    $requete2 = "SELECT nom_ue,id_ue FROM ue WHERE id_ue='$ues[0]'";
                    $result2 = mysqli_query($db, $requete2);
                    $row2 = mysqli_fetch_array($result2);
                    $nom = $row2['nom_ue'];
                    // echo '&nbsp;&nbsp;&nbsp;- '.$nom. '</br>';

                ?>
                    <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="check" id="mesUE" name='idue[]' value=" <?php echo $row2['id_ue']; ?>"> <?php echo $nom ?></input>

                    </div>
                <?php
                }
                ?><br>
                <div class="boutons">
                    <!-- Bouton qui supprime les liens entre l'etu et l'ue et le tuteur qui l'enseigne -->
                    <input type="submit" name="submit2" class="btn" id="bouton" value="Supprimer" />

                </div>
            </form>
        </div>
    </div>

    <?php
    // supprimer les ue selectionnées
    
    if (isset($_POST['submit2'])) {
        if (isset($_POST['idue'])) {
            $chr = $_POST['idue'];
            // oblige l'utilisateur à sélectionner une seule case
            if(count($_POST['idue'])>1){
                echo '<script>
                alert("Veuillez sélectionner une information à la fois");
                window.location.href = "./cours_etudiant.php";
                </script>';
                exit(); 
            }
            $requet1 = "SELECT id_tuteur FROM etudianttuteur WHERE id_etudiant='$id_user'";
            $resu1 = mysqli_query($db, $requet1);
            while ($etu = mysqli_fetch_array($resu1, MYSQLI_NUM)) {
                //Supprime lien entre l'etudiant et son tuteur
                $result4 = mysqli_query($db, "DELETE FROM etudianttuteur WHERE id_tuteur='$etu[0]' AND id_etudiant='$id_user'");
                $res = mysqli_query($db, "DELETE FROM utilisateurue WHERE id_utilisateur='$id_user' AND id_ue='$chr[0]'");
            }
            


            echo '<script>
                alert("Vos modifications ont été prise en compte");
                window.location.href = "./cours_etudiant.php";
                </script>';
                exit();
            
        }

    }


    ?>

    <?php
    // INSERTION TUTEURS ET UES CHOISI PAR L'ETUDIANT

    if (isset($_POST['SetTuteur'])) {
        $insertion = false;

        //Vérifie si l'etudiant a bien choisi une ue+un tuteur
        if ((!empty($_POST['ids']) && (!empty($_POST['tut'])))) {
            
            //Pour chaque tuteur
            foreach ($_POST['tut'] as $ctuteur) {
                
                $rqst = mysqli_query($db, "SELECT * FROM etudianttuteur WHERE id_etudiant='$id_user' AND id_tuteur='$ctuteur'");
                //Check si le tuteur et l'étudiant ne sont pas déja en relation
                if (mysqli_num_rows($rqst) == 0) {

                    //Check si le tuteur enseigne bien cette UE
                    foreach ($_POST['ids'] as $value) {
                        $requete5 = mysqli_query($db, "SELECT * FROM utilisateurue WHERE id_utilisateur='$ctuteur' AND id_ue='$value'");
                        //Si le tuteur ne correspond pas a l'ue 
                        if (mysqli_num_rows($requete5)==0){
                            echo '<script>
                            alert("Échec : Ce tuteur ne propose pas cette UE");
                            window.location.href = "./cours_etudiant.php";
                            </script>';
                            exit(); 
                        }


                        //Check si l'etudiant n'est pas déja en lien avec l'UE
                        $rqst2 = mysqli_query($db, "SELECT * FROM utilisateurue WHERE id_utilisateur='$id_user' AND id_ue='$value'");
                        //crée le lien avec l'ue si
                        if (mysqli_num_rows($rqst2) == 0) {
                            $requete3 = mysqli_query($db, "INSERT INTO utilisateurue(id_ue,id_utilisateur) VALUES ('$value', '$id_user')");

                            if ($requete3 == 1) {
                                $insertion = true;
                            }
                            
                        }
                        else{
                            echo '<script>
                            alert("Échec : UE déja sélectionnée");
                            window.location.href = "./cours_etudiant.php";
                            </script>';
                            exit(); 
                        }

                    }

                    //ajout du lien entre l'etudiant et son tuteur
                    $tutetu = mysqli_query($db, "INSERT INTO etudianttuteur(id_etudiant,id_tuteur) VALUES ('$id_user', '$ctuteur')");
                    if($tutetu == 1){
                        $insertion = true;
                    }
                }

                //tuteur etu lien existant
                else{
                    echo '<script>
                    alert("Échec : Erreur lors du choix effectué");
                    window.location.href = "./cours_etudiant.php";
                    </script>';
                    exit(); 
                }
                
            }
            if ($insertion == true) {
                echo '<script>
            alert("Votre choix a été pris en compte");
            window.location.href = "./cours_etudiant.php";
            </script>';
                exit();
            } else {
                echo '<script>
            alert("Échec : erreur lors de la sélection");
            window.location.href = "./cours_etudiant.php";
            </script>';
                exit();
            }
        }
        //si une seule donnée est coché
        else if((!empty($_POST['ids']) || (!empty($_POST['tut'])))){
            echo '<script>
            alert("Échec : Veuillez sélectionner une UE ET un tuteur");
            window.location.href = "./cours_etudiant.php";
            </script>';
                exit();
        }
    } ?>
    <!-- afficher les tuteurs choisis-->
    <div class="liste">
        <div class="liste_ue">
            <form action="./cours_etudiant.php" class="ue-form" method="post">
                <?php
                //afficher la liste des ue choisies
                echo "<h2>&nbsp;&nbsp; Mes Tuteurs: </h2></br> ";
                $requete1 = "SELECT id_tuteur FROM etudianttuteur WHERE id_etudiant='$id_user'";
                $result1 = mysqli_query($db, $requete1);
                while ($tuteurs = mysqli_fetch_array($result1)) {
                    $requete2 = "SELECT * FROM utilisateur WHERE id_utilisateur='$tuteurs[0]'";
                    $result2 = mysqli_query($db, $requete2);
                    $row2 = mysqli_fetch_array($result2);
                    $nom_tuteur = $row2['nom'];
                    $prenom_tuteur = $row2['prenom'];
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;- ' . $nom_tuteur . " " . $prenom_tuteur . '</br>';
                }?>
            </form>
            
        </div>
    </div>
    
<br>


</body>

</html>