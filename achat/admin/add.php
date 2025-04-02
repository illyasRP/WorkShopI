<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['produit'], $_POST['prix'], $_POST['Description'], $_POST['nombre']) &&
        !empty($_POST['produit']) && !empty($_POST['prix']) && !empty($_POST['Description']) && !empty($_POST['nombre']) &&
        isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        
        require_once('../connect.php');

       
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);
        $Description = strip_tags($_POST['Description']);

        
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];

      
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageExtension, $allowedExtensions)) {
            if ($imageSize <= 5000000) { 

         
                $newImageName = uniqid('', true) . '.' . $imageExtension;
                $imageDestination = '../uploads/' . $newImageName;

             
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                  
                    $sql = 'INSERT INTO `liste` (`image`, `Description`, `produit`, `prix`, `nombre`, `actif`) VALUES (:image, :Description, :produit, :prix, :nombre, 1);';
                    $query = $db->prepare($sql);

                  
                    $query->bindValue(':produit', $produit, PDO::PARAM_STR);
                    $query->bindValue(':prix', $prix, PDO::PARAM_STR);
                    $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);
                    $query->bindValue(':Description', $Description, PDO::PARAM_STR);
                    $query->bindValue(':image', $newImageName, PDO::PARAM_STR); // On insère le nom de l'image

                    // Exécution de la requête
                    $query->execute();

                    $_SESSION['message'] = "Produit ajouté avec succès!";
                    header('Location: /achat/admin/admin.php');
                    exit;
                } else {
                    $_SESSION['erreur'] = "Une erreur est survenue lors du téléchargement de l'image.";
                }
            } else {
                $_SESSION['erreur'] = "L'image est trop volumineuse. La taille maximale autorisée est 5 Mo.";
            }
        } else {
            $_SESSION['erreur'] = "L'image doit être au format JPG, JPEG, PNG ou GIF.";
        }

        require_once('../close.php');

    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplet ou l'image est invalide.";
    }
    
if (!file_exists('../uploads/')) {
   
    mkdir('../uploads/', 0777, true); 
}


if (move_uploaded_file($imageTmpName, $imageDestination)) {
 
} else {
    $_SESSION['erreur'] = "Une erreur est survenue lors du téléchargement de l'image.";
}
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <style>
    body {
        background: linear-gradient(to right, rgb(0, 0, 0), rgb(73, 73, 73));
    }
    h1 {
        color: gold;
    }
    label {
        color: gold;
    }
    a {
        margin: 20px;
    }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <a href="/achat/admin/adminer.php" class="btn btn-warning">Retour</a>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if (!empty($_SESSION['erreur'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                        $_SESSION['erreur'] = "";
                    }
                    if (!empty($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Ajouter un produit</h1>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="Description">Description</label>
                        <input type="text" id="Description" name="Description" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="number" id="prix" name="prix" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="form-control" >
                    </div><br>

                    <button class="btn btn-warning" type="submit">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
