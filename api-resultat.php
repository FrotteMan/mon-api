<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if ($id == 1) {
            // Récupérer les compétitions
            $stmt = $pdo->query("SELECT id_competition, nom_competition FROM competition");
            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($competitions);

        } elseif ($id == 2) {
            // Récupérer les équipes
            $stmt = $pdo->query("SELECT id_equipe, nom_equipe FROM equipe");
            $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($equipes);
        } else {
            echo json_encode(['error' => 'ID non reconnu']);
        }
    } else {
        echo json_encode(['error' => 'ID manquant']);
    }

} elseif ($method === 'POST') {
    // Vérification des champs attendus
    if (isset($_POST['competition_id'], $_POST['equipe_id'], $_POST['position'])) {
        $competition_id = $_POST['competition_id'];
        $equipe_id = $_POST['equipe_id'];
        $position = $_POST['position'];

        try {
            // Exécuter la procédure stockée
            $stmt = $pdo->prepare("CALL ajouter_resultat(?, ?, ?)");
            $stmt->execute([$competition_id, $equipe_id, $position]);

            echo json_encode(['success' => true, 'message' => 'Résultat ajouté avec succès.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

    } else {
        echo json_encode(['error' => 'Champs manquants']);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}
