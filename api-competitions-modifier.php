<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Récupère la compétition.
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Préparer la requête.
        $stmt = $pdo->prepare("
            SELECT * FROM competition WHERE id_competition = ?
        ");
        $stmt->execute([$id]);
        $competition = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($competition);
    }
} elseif ($method === 'POST') {
    // Mise à jour d'une compétition
    if (isset($_POST['id_competition'])) {
        $id = $_POST['id_competition'];
        $nom = $_POST['nom_competition'];
        $date = $_POST['date_competition'];
        $lieu = $_POST['lieu'];
        $nb_equipes = $_POST['nb_equipes'];

        // Préparer la requête UPDATE
        $sql = $pdo->prepare("UPDATE competition SET nom_competition=?, date_competition=?, lieu=?, nb_equipes=? WHERE id_competition=?");
        $sql->execute([$nom, $date, $lieu, $nb_equipes, $id]);

        echo json_encode(['success' => 'Compétition mise à jour']);
    } else {
        echo json_encode(['error' => 'ID de compétition manquant']);
    }
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}
