<?php
require 'connexion.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_competition'])) {
        $id = $_POST['id_competition'];

        try {
            $stmt = $pdo->prepare("DELETE FROM competition WHERE id_competition = ?");
            $stmt->execute([$id]);

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID manquant']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}
