<?php 
session_start();

if(isset($_POST['uname']) && isset($_POST['pass'])){

    include "../db_conn.php";

    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "uname=".$uname;

    // Vérification des champs vides
    if(empty($uname)){
        $em = "Pseudo requis";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else if(empty($pass)){
        $em = "Mots de passe requis";
        header("Location: ../login.php?error=$em&$data");
        exit;
    } else {
        // Requête pour récupérer l'utilisateur
        $sql = "SELECT * FROM users WHERE uname=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe
        if(isset($users[0])) {
            $user = $users[0];
            $username =  $user['uname'];
            $u_password =  $user['password'];
            $fname =  $user['fname'];
            $id =  $user['id'];
            $admin =  $user['admin'];
            $Sadmin =  $user['Sadmin'];

            // Vérification du nom d'utilisateur et du mot de passe
            if ($username === $uname && password_verify($pass, $u_password)) {
                // Définir les variables de session
                $_SESSION['id'] = $id;
                $_SESSION['fname'] = $fname;
                $_SESSION['admin'] = $admin;
                $_SESSION['Sadmin'] = $Sadmin;

                // Vérification du rôle
                if ($Sadmin == 1) {  // Super admin
                    header("Location: ../admin/me.php");
                    exit;
                } elseif ($admin == 1) {  // Admin mais pas super admin
                    header("Location: ../admin/adminer.php");
                    exit;
                } else {  // Utilisateur normal
                    header('Location: /achat/user12.php');
                    exit;
                }
            } else {
                // Erreur mot de passe ou pseudo incorrect
                $em = "Pseudo ou mot de passe incorrect";
                header("Location: ../login.php?error=$em&$data");
                exit;
            }
        } else {
            // Erreur si l'utilisateur n'existe pas
            $em = "Pseudo ou mot de passe incorrect";
            header("Location: ../login.php?error=$em&$data");
            exit;
        }
    }
}
?>
