<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./compte_param.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="main">

    <?php
    @ini_set('display_errors', 'on');
    include "../bdd_cnx/mysqli_cnx.php";
    session_start();
    include "./sidebar.php";
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
        $mdp = mysqli_real_escape_string($db, htmlspecialchars($_POST['mdp']));

        if ($email !== "" && $mdp !== "") {
            $requete = "SELECT id_utilisateur, nom, prenom, roles, user_email_status FROM utilisateur WHERE email = '$email' and mdp = '$mdp'";
            $result = mysqli_query($db, $requete);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);

            if ($count == 1) //email et mdp correct
            {
                $id = $row['id_utilisateur'];
                $nom = $row['nom'];
                $role = $row['roles'];
                $prenom = $row['prenom'];
                $user_email_status = $row['user_email_status'];
                $_SESSION['email'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['id'] = $id;
                $_SESSION['roles'] = $role;
                $_SESSION['user_email_status'] = $user_email_status;
            }
        }
    }

    if (isset($_GET['supression'])) {
        $d = $_SESSION['id'];

        $query1 = "DELETE FROM utilisateur WHERE id_utilisateur='$d'";
        $query2 = "DELETE FROM utilisateurue WHERE id_utilisateur='$d'";
        $query3 = "DELETE FROM etudianttuteur WHERE id_etudiant='$d'";
        $query4 = "DELETE FROM etudianttuteur WHERE id_tuteur='$d'";
        $query5 = "DELETE FROM events WHERE id_tuteur = $d OR id_etudiant=$d";
        $query6= "DELETE FROM review_table WHERE id_utilisateur=$d";

        $del6 = mysqli_query($db, $query6);
        $del5 = mysqli_query($db, $query5);
        $del3 = mysqli_query($db, $query3);
        $del4 = mysqli_query($db, $query4);
        $del2 = mysqli_query($db, $query2);
        $del1 = mysqli_query($db, $query1);


    if($del6){
        if ($del5) {
            if ($del3 || $del4) {
                if ($del2) {
                    if ($del1) {
                        session_unset();
                        mysqli_close($db);
                        header("location:../inscription&connection/ins_cnx.php");
                        exit();
                    } else {
                        header("location: compte_param.php?erreur=pasdesupression del1");
                    }
                } else {
                    header("location: compte_param.php?erreur=pasdesupression del2");
                }
            } else {
                header("location: compte_param.php?erreur=pasdesupression del3 del4");
            }
        } else {
            header("location: compte_param.php?erreur=pasdesupression del5");
        }
    }else{
        header("location: compte_param.php?erreur=pasdesupression del6");
    }
    }
    $id = $_SESSION['id'];
    $stmt = "SELECT email FROM utilisateur WHERE id_utilisateur='$id'";
    $result = mysqli_query($db, $stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $email = $row['email'];
    }
    ?>
    <div class="titre">
        <h3>Mon compte</h3>
    </div>
    <div class="liste info">
        <div class="sous-titre">
        <h2>&nbsp;&nbsp; Informations Générales</h2></br>
        </div>
        
        <ul class="liinfo">
            <li>Nom : <b><?php echo $_SESSION['email']; ?></b></li>
            <li>Prénom : <b><?php echo $_SESSION['prenom']; ?></b></li>
            <li>Mail : <b><?php echo $email; ?></b></li>
            <li>Statut : <b><?php if ($_SESSION['roles'] == 'T') echo "Tuteur";
                            else echo "Etudiant"; ?></b></li>
        </ul>
        
    </div>

    <div class="liste formulaire">
    <div class="sous-titre">
    <h2>&nbsp;&nbsp; Modifier mon mot de passe </h2></br>
        </div>
        <div class="fsupp">
        <form action="./compte_param.php" method="POST" class="main">
            &nbsp;&nbsp;<input name="email" id="email" type="text" placeholder="Entrer l'adresse mail" required>
            <br>
            &nbsp;&nbsp;<input name="password" id="password" type="password" placeholder="Mot de passe actuel" required>
            <br>
            &nbsp;&nbsp;<input name="password1" id="password" type="password" placeholder="Nouveau Mot de passe" required>
            <br>
            &nbsp;&nbsp;<button name="submit1" class="submitp" class="btn" >Changer Mot de Passe</button>
        </form>
</div>
    </div>
    <div class=" liste suppression">
    <div class="supp">
    <h2>&nbsp;&nbsp;&nbsp;&nbsp; Supprimer mon compte </h2></br>
        <button class="bsupp" ><a href="compte_param.php?supression=true">Suppression</a></button>
</div>
    </div>
    <?php
    $d = $_SESSION['id'];

    @ini_set('display_errors', 'on');
    if (isset($_POST['submit1'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $pasword = mysqli_real_escape_string($db, $_POST['password']);
        $newpassword = mysqli_real_escape_string($db, $_POST['password1']);
        echo "test";

        $sql = "select * from utilisateur where id_utilisateur='$d'" or die("Failed to query Database" . mysql_error());
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) <= 0) {
            echo '<script>
    alert("ERREUR \n Veuillez entrez une adresse mail valide!");
    window.location.href = "./compte_param.php";
    </script>';
            exit();
        } else {
            $query = "UPDATE utilisateur SET mdp='$newpassword' where id_utilisateur='$d' AND mdp='$pasword'";
            $output = mysqli_query($db, $query);
            echo '<script>
    alert("Votre mot de passe a été modifié!");
    window.location.href = "./compte_param.php";
    </script>';
            exit();
        }
    }

    ?>

</br>
</body>

</html>