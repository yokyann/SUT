<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./sidebar.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   </head>
<body>
<div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">SUT</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <li>
      <a href="./compte_acceuil.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Accueil</span>
        </a>
         <span class="tooltip">Accueil</span>
      </li>
    
      <li>
      <?php if ($_SESSION['roles'] == 'E'){ ?>
       <a href="./cours_etudiant.php">
         <?php ;} else{ ?>
          <a href="./cours_tuteur.php">
            <?php ;} ?>
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
       <a href="./planning.php">
        <i class='bx bx-calendar'></i>
         <span class="links_name">Planning</span>
       </a>
       <span class="tooltip">Planning</span>
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
    <script src="./sidebar.js"></script>
</body>
</html>