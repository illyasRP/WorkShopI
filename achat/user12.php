<?php 
session_start();

if ( isset ($_SESSION['id']) && isset ($_SESSION['fname']) ) {
 ?>
<?php include( './component/header.php') ?> 
<style>
    body{
        background: linear-gradient(to right,rgb(0, 0, 0),rgb(73, 73, 73));
        color: gold;
    }
</style>
<body>
<?php include( './component/nav.php') ?> 
    <div class="d-flex justify-content-center align-items-center vh-100 style="width: 100rem;">
    	
    	<div class="shadow w-450 p-3 text-center">
            <h3 class="display-4 ">Bonjour, <?=$_SESSION['fname']?> </h3>
            
            <a href="logout.php" class="btn btn-warning">
            	deconnexion
            </a>
            <a href="index.php" class="btn btn-primary">
            	page principale
            </a>
		</div>
    </div>
</body>
</html>

<?php }else {
	header("Location: login.php");
	exit;
} ?>