<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Récupère tout les adhérents.
	$stmt = $pdo->query("
		SELECT 
			e.nom_equipe, 
			c.nom_club,
			SUM(r.points) AS total_points
		FROM resultat r
		JOIN equipe e ON r.equipe_id = e.id_equipe
		JOIN club c ON e.club_id = c.id_club
		GROUP BY e.id_equipe, c.nom_club
		ORDER BY total_points DESC
	");
	$equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($equipes);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}