<?php
session_start();

if ($_POST) {
    if (
        isset($_POST['id']) && !empty($_POST['id']) &&
        isset($_POST['produit']) && !empty($_POST['produit']) &&
        isset($_POST['prix']) && !empty($_POST['prix']) &&
        isset($_POST['actif']) && !empty($_POST['actif']) &&
        isset($_POST['Description']) && !empty($_POST['Description']) &&
        isset($_POST['nombre']) && !empty($_POST['nombre'])
    ) {
        try {
            $db = new PDO('mysql:host=localhost;dbname=corteiz', 'root', 'root');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }

        $id = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);
        $actif = strip_tags($_POST['actif']);
        $Description = strip_tags($_POST['Description']);
        $image = strip_tags($_POST['image']);

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $newImage = $_FILES['image'];
            $imageName = $newImage['name'];
            $imageTmpName = $newImage['tmp_name'];
            $imageSize = $newImage['size'];
            $imageError = $newImage['error'];
            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($imageExtension, $allowedExtensions)) {
                if ($imageSize <= 5000000) {
                    $newImageName = uniqid('', true) . '.' . $imageExtension;
                    $imageDestination = '../uploads/' . $newImageName;
                    if (move_uploaded_file($imageTmpName, $imageDestination)) {
                        $image = $newImageName;
                    } else {
                        $_SESSION['erreur'] = "Une erreur est survenue lors du téléchargement de l'image.";
                        header('Location: edit.php?id=' . $id);
                        exit();
                    }
                } else {
                    $_SESSION['erreur'] = "L'image est trop volumineuse. La taille maximale autorisée est 5 Mo.";
                    header('Location: edit.php?id=' . $id);
                    exit();
                }
            } else {
                $_SESSION['erreur'] = "L'image doit être au format JPG, JPEG, PNG ou GIF.";
                header('Location: edit.php?id=' . $id);
                exit();
            }
        }

        $sql = 'UPDATE `liste` SET `image`=:image, `produit`=:produit, `prix`=:prix, `actif`=:actif, `Description`=:Description, `nombre`=:nombre WHERE `id`=:id';
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);
        $query->bindValue(':actif', $actif, PDO::PARAM_INT);
        $query->bindValue(':Description', $Description, PDO::PARAM_STR);
        $query->bindValue(':image', $image, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['message'] = "Produit modifié";
        require_once('../close.php');
        header('Location: admin.php');
        exit();
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        $db = new PDO('mysql:host=localhost;dbname=corteiz', 'root', 'root');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        die();
    }

    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $produit = $query->fetch();

    if (!$produit) {
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: admin.php');
        exit();
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
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
<body><br><br><br>
<a href="/achat/admin/admin.php" class="btn btn-warning">Retour</a>
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
            <h1>Modifier un produit</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Image actuelle</label>
                    <input type="text" id="image" name="image" class="form-control" value="<?= $produit['image'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="produit">Produit</label>
                    <input type="text" id="produit" name="produit" class="form-control" value="<?= $produit['produit'] ?>">
                </div>
                <div class="form-group">
                    <label for="prix">Prix</label>
                    <input type="text" id="prix" name="prix" class="form-control" value="<?= $produit['prix'] ?>">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre'] ?>">
                </div>
                <div class="form-group">
                    <label for="Description">Description</label>
                    <input type="text" id="Description" name="Description" class="form-control" value="<?= $produit['Description'] ?>">
                </div>
                <div class="form-group">
                    <label for="actif">Actif</label>
                    <select name="actif" id="actif" class="form-control">
                        <option value="1" <?= $produit['actif'] == 1 ? 'selected' : '' ?>>Actif</option>
                        <option value="0" <?= $produit['actif'] == 0 ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </div>
                <input type="hidden" value="<?= $produit['id'] ?>" name="id">
                <div class="form-group">
                    <label for="image">Nouvelle Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>
                <button class="btn btn-primary">Envoyer</button>
            </form>
        </section>
    </div>
</main>
</body>
</html>
