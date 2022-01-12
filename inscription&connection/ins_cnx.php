<!DOCTYPE html>
<html lang="fr">
  <?php
  @ini_set('display_errors', 'on');
  ?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./ins_cnx.css" />
  <title>Inscription et connection</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="../compte/compte_acceuil.php" class="sign-in-form" method="post">
          <!--CONNEXION!!-->
          <h2 class="title">Connexion</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="mdp" placeholder="Mot de Passe" required/>
          </div>
          <input type="submit" name="submit" value="Se Connecter" class="btn solid" />
          
        </form>


        <form action="./session_cnx.php" class="sign-up-form" method="post">
          <!--INSCRIPTION!!-->
          <h2 class="title">S'inscrire</h2>
          <div class="input-field optionss" id="wrapper">
            <input type="radio" name="role" value="E" id="option-1" checked>
            <input type="radio" name="role" value="T" id="option-2">
            <label for="option-1" class="option option-1">
              <div class="dot"></div>
              <span>Etudiant</span>
            </label>
            <label for="option-2" class="option option-2">
              <div class="dot"></div>
              <span>Tuteur</span>
            </label>
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="nom" placeholder="Nom" required />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="prenom" placeholder="Prénom" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="mdp" placeholder="Mot de passe" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="c_mdp" placeholder="Confirmer Mot de Passe" required/>
          </div>
          <input type="submit" name="submit" class="btn" value="S'inscrire" />
          
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Nouveau ici ?</h3>
          <p>
            Etudiant ou tuteur, besoin d'aide ou envie d'aider ? Juste inscris-toi !
          </p>
          <button class="btn transparent" id="sign-up-btn">
            S'inscrire
          </button>
        </div>
        <img src="../page_acceuil/image/log.svg" class="image" alt="" style="max-width:100%;height:auto;"/>
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Déja membre ?</h3>
          <p>
            Connecte-toi !
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Connexion
          </button>
        </div>
        <img src="../page_acceuil/image/register.svg" class="image" alt="" style="max-width:100%;height:auto;"/>
      </div>
    </div>
  </div>

  <script src="./ins_cnx.js"></script>
</body>

</html>