<?php 

if(isset($_POST['fname']) && 
   isset($_POST['uname']) && 
   isset($_POST['pass'])){

    include "../db_conn.php";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $password = $_POST['pass'];
	$email = $_POST["email"];

    $data = "fname=".$fname."&uname=".$uname;
    
    if (empty($fname)) {
    	$em = "Nom est obligatoire";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else if(empty($uname)){
    	$em = "Un pseudo est obligatoire";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
	}else if(empty($email)){
    	$em = "Email est obligatoire";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else if(empty($password)){
    	$em = "Mots de passe est obligatoire";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else {

    	// hashing the password
    	$hashedpass = password_hash($password, PASSWORD_DEFAULT);

    	$sql = "INSERT INTO users(fname, uname, password, email) 
    	        VALUES(?,?,?,?)";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$fname, $uname, $hashedpass, $email]);

    	header("Location: ../user12.php?success=Your account has been created successfully");
	    exit;
    }


}else {
	header("Location: ../index.php?error=error");
	exit;
}