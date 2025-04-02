<?php

session_start();

$db = new PDO('mysql:host=localhost;dbname=corteiz', 'root', 'root');
$db->exec('SET NAMES "UTF8"');

$sql = 'SELECT * FROM `liste`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll();

$action_done = isset($_POST['action']) && $_POST['action'] == 'changer';

require_once('close.php');

?> 

<?php include( './component/header.php') ?> 


<?php include( './component/nav.php') ?> 

    
    <script>
      function togglePanier() {
    var panier = document.getElementById('panier');
    panier.classList.toggle('open');
}

    </script>
    
<div id="popup-overlay" class="open" >
    <div class="popup-content">
        <h1>Bonjour</h1><br>
        <p>Avant de acceder vers Corteiz.be veuillez accepter tous les cookies</p><br>
        <a href="javascript:void(0)" onclick="togglePopup()" class="popup-link">Accepter les cookies</a>

    </div>
</div>
   
        
        
    

<script src="./js/app.js"></script>


<img class="acc" src="https://corteizsite.fr/wp-content/uploads/2024/10/corteiz-france-banner-1024x413.webp"
alt="" width="100%" height="">

<br>
<main class="">
    <div class="container">
        <div class="row">
        <?php
foreach($result as $produit){
?>
    <div class="col-12 col-md-4 col-lg-4">
        <div class="article">
            <a href="article.php?id=<?= $produit['id'] ?>">
                <!-- Met à jour le chemin d'accès à l'image -->
                <img class="at" src="uploads/<?= $produit['image'] ?>" alt="">
            </a>
            <h3><strong class="iem-title"><?= $produit['produit'] ?></strong></h3>
            <h4><?= $produit['prix'] ?>€</h4>
            
        
        </div>
    </div>
<?php
}
?>

        </div>
    </div>
</main>


<br>
<br>



 
    <?php include( './component/footer.php') ?>  

