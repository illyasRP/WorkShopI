<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once('../connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    // On vérifie que l'id est un entier valide
    if (!is_numeric($id)) {
        $_SESSION['erreur'] = "ID invalide.";
        header('Location: adminer.php');
        exit;
    }

    // Sélectionner le produit pour voir s'il existe
    $sql = 'SELECT * FROM `liste` WHERE `id` = :id;';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $produit = $query->fetch();

    // Si le produit existe
    if ($produit) {
        // Exécuter la suppression
        $sql = 'DELETE FROM `liste` WHERE `id` = :id;';
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message'] = "Produit supprimé avec succès.";
        header('Location: admin.php');
        exit;
    } else {
        // Si le produit n'existe pas
        $_SESSION['erreur'] = "Le produit n'existe pas.";
        header('Location: admin.php');
        exit;
    }
} else {
    // Si l'ID est manquant ou vide dans l'URL
    $_SESSION['erreur'] = "URL invalide.";
    header('Location: admin.php');
    exit;
}
