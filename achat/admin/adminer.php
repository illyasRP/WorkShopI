<?php 
session_start();

if ( isset ($_SESSION['id']) && isset ($_SESSION['fname']) ) {
 ?>

<style>
    body{
        background: linear-gradient(to right,rgb(0, 0, 0),rgb(73, 73, 73));
        color: gold;
    }
</style>
<!DOCTYPE html>
<html>
	<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../style.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<style>
		body{
			background: linear-gradient(to right,rgb(10, 10, 10),rgb(85, 85, 85));
			color: gold;
		}
	</style>
	</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100 style="width: 100rem;">
    	
    	<div class="shadow w-500 p-3 text-center">
			<h3 class="display-4 ">Bonjour admin, (<?=$_SESSION['fname']?>)</h3><br>
			          
            <a href="/achat/logout.php" class="btn btn-warning">
            	Deconnexion
            </a>
            <a href="/achat/" class="btn btn-primary">
			Page d'accueil
            </a>
			<a href="/achat/admin/admin.php" class="btn btn-success">
            	Modifier un produit
            </a>
			<a href="/achat/admin/add.php" class="btn btn-light">
            	Ajouter un produit
            </a>
		</div>
    </div>
	<button type="reset">yep</button>
</body>
</html>

<?php }else {
	header("Location: login.php");
	exit;
} ?>
