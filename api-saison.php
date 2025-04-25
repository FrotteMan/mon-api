<?php
require 'connexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $saison = isset($_GET['saison']) ? intval($_GET['saison']) : 0;

    $stmt = $pdo->prepare("
        SELECT 
            c.nom_club,
            SUM(r.points) AS total_points
        FROM resultat r
        JOIN equipe e ON r.equipe_id = e.id_equipe
        JOIN club c ON e.club_id = c.id_club
        WHERE r.saison = :saison
        GROUP BY c.id_club
        ORDER BY total_points DESC
    ");
    
    $stmt->execute(['saison' => $saison]);
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($clubs);
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}
