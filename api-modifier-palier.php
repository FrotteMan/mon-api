<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Préparer la requête.
        $stmt = $pdo->prepare("SELECT * FROM palier WHERE id_palier = ?");
        $stmt->execute([$id]);
        $palier = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($palier);
    } else {
        // ID manquant
        echo json_encode(['error' => 'ID du palier manquant']);
    }
} elseif ($method === 'POST') {
    // Mise à jour d'un palier
    if (isset($_POST['id_palier'])) {
        $id = $_POST['id_palier'];
        $nom = $_POST['nom_palier'];
        $nbr_pts_minimum = $_POST['nbr_pts_minimum_palier'];

        $sql = $pdo->prepare("UPDATE palier SET nom_palier=?, nbr_pts_minimum_palier=? WHERE id_palier=?");
        $sql->execute([$nom, $nbr_pts_minimum, $id]);

        echo json_encode(['success' => 'Palier mis à jour']);
    } else {
        echo json_encode(['error' => 'ID de palier manquant']);
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}
