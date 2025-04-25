<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Récupère toutes les compétitions à venir
    $stmt = $pdo->query("
        SELECT c.id_competition, c.nom_competition, c.date_competition, c.lieu, 
               cat.nom_categorie, t.nom_type, c.nb_equipes
        FROM competition c
        JOIN categorie cat ON c.categorie_id = cat.id_categorie
        JOIN type_competition t ON c.type_id = t.id_type
        WHERE c.date_competition >= CURDATE()
        ORDER BY c.date_competition ASC
    ");
    $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($competitions);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}
