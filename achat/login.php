
<?php include( './component/header.php') ?> 

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap");

      body {
        background: linear-gradient(to right,rgb(0, 0, 0),rgb(73, 73, 73));
		color: white;
        font-family: "Space Grotesk", sans-serif;
      }

	  input{
		color: black;
	  }
      input:focus {
        outline: none;
      }
    </style>
	
	<?php include( './component/nav.php') ?> 
	<body class="flex items-center justify-center min-h-screen bg-gray-50">

	
	<script src="./js/login.js"></script>
    <div class="d-flex justify-content-center align-items-center vh-100">
		
		<form class="shadow w-700 p-3" 
		action="php/login.php" 
		method="post">
		
		<h4 class="display-4  fs-1">Connexion</h4><br>
		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
				<?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>
			
			<div class="mb-3">
				<label class="form-label">Pseudo</label><br>
				<input type="text" 
				class="w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm transition-all duration-300"
				name="uname"
				value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>"
				>
			</div>
			
			<div class="mb-3">
				<label class="form-label">Mots de passe</label><br>
				<input type="password" 
		           class="w-full px-4 py-3 border border-gray-200 rounded-lg shadow-sm transition-all duration-300"
		           name="pass"
				   >
				</div>
				<div class="flex justify-between items-center">
            <label
              class="flex items-center text-sm text-gray-600"
              id="remember-me"
            >
              <input
                type="checkbox"
                class="form-checkbox h-4 w-4 text-teal-600 border-gray-300 rounded transition duration-200"
              />
              <span class="ml-2">Se rappeler de moi</span>
            </label>
       
          </div>
				<div id="sign-in-button">
				<button type="submit" class="btn btn-primary">Connexion</button>
				<p class="box-register">Vous êtes nouveau ici? <a href="signup.php">S'inscrire</a></p>
			</form>
		</div>

	<script>
    // Show modal after successful login (you can replace this with your own logic)
    <?php if (isset($_GET['login']) && $_GET['login'] == 'success') { ?>
      // Display the success popup modal
      var loginSuccessModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'));
      loginSuccessModal.show();
    <?php } ?>
  </script>

	</body>
	</html>