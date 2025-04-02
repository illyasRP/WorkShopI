<?php
// On démarre une session
// session_start();

// On inclut la connexion à la base
require_once('../connect.php');

$sql = 'SELECT * FROM `liste`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('../close.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
<style>
    a{
        margin: 15px;
    }
      body{ 
        background: linear-gradient(to right,rgb(0, 0, 0),rgb(73, 73, 73));
        color: gold;
    }
    th{
        color: gold;
    }
    tr{
        color: gold;
    }
    h1{
        color: gold;
    }
</style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<a href="/achat/admin/adminer.php" class="btn btn-warning">
            	Back
            </a>
    <main class="container">
        <div class="row">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <h1>Liste des produits</h1>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>image</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Nombre</th>
                        <th>Actif</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $produit){
                        ?>
                            <tr>
                                <td><?= $produit['id'] ?></td>
                                <td><?= $produit['image'] ?></td>
                                <td><?= $produit['produit'] ?></td>
                                <td><?= $produit['prix'] ?>€</td>
                                <td><?= $produit['nombre'] ?></td>
                                <td><?= $produit['actif'] ?></td>
                                <td><?= $produit['Description'] ?></td>
                                <td>
                                <a class="btn btn-warning" href="../article.php?id=<?= $produit['id'] ?>">Voir </a>

                                <a class="btn btn-warning" href="/achat/admin/edit.php?id=<?= $produit['id'] ?>">Modifier</a>
                                <a class="btn btn-warning" href="/achat/admin/delete.php?id=<?= $produit['id'] ?>">Suprimer </a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <a href="/achat/admin/add.php" class="btn btn-warning">Ajouter un produit</a>
            
        </a>
            </section>
        </div>
    </main>
</body>
</html>