<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Récupère tout les adhérents.
	$stmt = $pdo->query("SELECT nom_joueur, prenom_joueur, points_joueur
            FROM joueur
            WHERE palier_id = 3
            ORDER BY points_joueur DESC
	");
	$joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($joueurs);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}