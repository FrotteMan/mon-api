<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Récupère tout les adhérents.
	$stmt = $pdo->query("SELECT * FROM palier ORDER BY nbr_pts_minimum_palier ASC
	");
	$paliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($paliers);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}