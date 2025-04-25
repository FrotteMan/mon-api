<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Récupère tout les adhérents.
	$stmt = $pdo->query("SELECT a.nom_joueur, a.prenom_joueur, YEAR(CURDATE()) - YEAR(a.date_de_naissance_joueur) AS age,
            CASE 
              WHEN YEAR(CURDATE()) - YEAR(a.date_de_naissance_joueur) < 18 THEN 'U18'
              WHEN YEAR(CURDATE()) - YEAR(a.date_de_naissance_joueur) <= 40 THEN 'Senior'
              ELSE 'Vétéran'
            END AS categorie_age,
            c.nom_club
            FROM joueur a
            JOIN club c ON a.club_id = c.id_club
	");
	$adherents = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($adherents);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}