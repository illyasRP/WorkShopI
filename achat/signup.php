<?php

// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['fname']) && !empty($_POST['fname'])
    && isset($_POST['uname']) && !empty($_POST['uname'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['password']) && !empty($_POST['password'])){
        // On inclut la connexion à la base
        require_once('connect.php');

        // On nettoie les données envoyées
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags(  $_POST['nombre']);

        $sql = 'INSERT INTO `users` (`email`, `password`, `fname`, `uname` ) VALUES (:email, :password, :fname, uname);';

        $query = $db->prepare($sql);

        $query->bindValue(':fname', $fname, PDO::PARAM_STR);
		$query->bindValue(':uname', $uname, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_INT);
        $query->bindValue(':password', $password, PDO::PARAM_STR);


    }
}

?>


<?php include( './component/header.php') ?> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="./js/login2.js"></script>
<style>
	  body {
        background: linear-gradient(to right,rgb(73, 73, 73),rgb(0, 0, 0));
		color: white;
      }
</style>
<?php include( './component/nav.php') ?> 
    <div class="d-flex justify-content-center align-items-center vh-100">
    	
    	<form class="shadow w-450 p-3" 
    	      action="php/signup.php" 
    	      method="post">

    		<h4 class="display-4  fs-1">Create Account</h4><br>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		    <?php if(isset($_GET['success'])){ ?>
    		<div class="alert alert-success" role="alert">
			  <?php echo $_GET['success']; ?>
			</div>
		    <?php } ?>
		  <div class="mb-3">
		    <label class="form-label">Full Name</label>
		    <input type="text" 
		           class="form-control"
		           name="fname"
		           value="<?php echo (isset($_GET['fname']))?$_GET['fname']:"" ?>"
				   >
		  </div>

		  <div class="mb-3">
		    <label class="form-label">User name</label>
		    <input type="text" 
		           class="form-control"
		           name="uname"
		           value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>"
				   >
		  </div>
          <div class="mb-3">
		    <label class="form-label">E-Mail</label>
		    <input type="mail" 
		           class="form-control"
		           name="email"
		           value="<?php echo (isset($_GET['email']))?$_GET['email']:"" ?>"
				   >
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" 
		           class="form-control"
		           name="pass"
				   
                   value="<?php echo (isset($_GET['password']))?$_GET['password']:"" ?>"
				  >
		  </div>
		  
		  
		  <button type="submit" class="btn btn-primary">Sign Up</button>

		  <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
		</form>
    </div>
    <?php include( './component/footer.php') ?>  
</body>
</html>