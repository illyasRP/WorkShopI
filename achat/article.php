<?php

$db = new PDO('mysql:host=localhost;dbname=corteiz', 'root', 'root');
$db->exec('SET NAMES "UTF8"');


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);  

   
    $sql = 'SELECT * FROM `liste` WHERE `id` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();


    $produit = $query->fetch();

  
    if (!$produit) {
        $_SESSION['erreur'] = "Produit non trouvé.";
        header('Location: a.php');  
        exit;
    }
} else {
   
    $_SESSION['erreur'] = "ID manquant.";
    header('Location: b.php');  
    exit;
}

require_once('close.php');
?>

<?php include( './component/header.php') ?>
<link rel="stylesheet" href="./CSS/article.css">
<?php include( './component/nav.php') ?>

<main>
    <div class="card" style="width: 50rem;">
        <img class="at" src="uploads/<?= $produit['image'] ?>" alt="" width="50%">
        <div class="card-body">
            <h2 class="card-title"><?= $produit['produit'] ?></h2>
            <?= $produit['prix'] ?> $<br>
            <p class="card-text"><?= $produit['Description'] ?></p>
            <?= $produit['nombre'] ?> de disponible<br>
        </div>
    </div>
</main>

<?php include( './component/footer.php') ?>    
</body>
</html>
