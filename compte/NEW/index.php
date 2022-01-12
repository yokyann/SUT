<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Avis sur votre tuteur</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script defer src="jquery.js"></script>
		
		<?php 
		session_start();
		$_SESSION['monid']=$_GET['id'];?>
		<style>
			.card-header, .btn{
				background: #a1ceee;
				border: none;
			}
            .progress-label-left {
                float: left;
                margin-right: 0.5em;
                line-height: 1em;
            }
            .progress-label-right {
                float: right;
                margin-left: 0.3em;
                line-height: 1em;
            }
            .star-light { 
                color: #e9ecef;
            }
			
        </style>
	</head>
<?php
$id = $_GET['id']; //collect data after submiting an html form, can also connect data sent in the url
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sut";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname); //an object representing the connection to the database, or FALSE on failure.
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM utilisateur WHERE id_utilisateur =$id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $name = $row["nom"];
    $lastname = $row["prenom"];
  }
}
?>
		
	<body>
		<div class="container">
			<h1 class="mt-5 mb-5">Donnez votre avis </h1>
			<div class="card">
				<div class="card-header"><?= $name ?> <?= $lastname ?></div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-4 text-center">
							<h1 class="text-warning mt-4 mb-4">
								<b><span id="average_rating"></span> / 5</b>
							</h1>
							<div class="mb-3">
								<?php for ($i = 1; $i <= 5; $i++) {?>
									<i class="fas fa-star star-light mr-1 main_star"></i>
								<?php }?>
							</div>
							<h3><span id="total_review"></span> Avis</h3>
						</div>
						<div class="col-sm-4">
							<?php for ($i = 5; $i >= 1; $i--) {?>
							<p>
								<div class="progress-label-left"><b><?php echo $i; ?></b> <i class="fas fa-star text-warning"></i></div>

								<div class="progress-label-right">(<span id="total_<?php echo $i; ?>_star_review"></span>)</div>
								<div class="progress">
									<div id="<?php echo $i; ?>_star_progress" class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</p>
							<?php }?>
						</div>
						<div class="col-sm-4 text-center">
							<h3 class="mt-4 mb-3 col-12">Ecrivez votre avis</h3>
							<button type="button" name="add_review" id="add_review" class="btn btn-primary">Nouvel Avis</button>
						</div>
					</div>
				</div>
			</div>
			<div class="mt-5" id="review_content"></div>
		</div>
		<div id="review_modal" class="modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Infos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h4 class="text-center mt-2 mb-4">
							<?php for ($i = 1; $i <= 5; $i++) {?>
							<i class="fas fa-star star-light submit_star mr-1" id="submit_star_<?php echo $i; ?>" data-rating="<?php echo $i; ?>"></i>
							<?php }?>
						</h4>
						<div class="form-group">
							<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Entrer votre nom"/>
						</div>
						<div class="form-group">
							<textarea name="user_review" id="user_review" class="form-control" placeholder="Ecrivez votre avis ici"></textarea>
						</div>
						<div class="form-group text-center mt-4">
							<button type="button" class="btn btn-primary" id="save_review">Envoyer</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>