<?php
require 'connexion.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
	// Récupère toutes les compétitions.
	$stmt = $pdo->query("
		SELECT c.id_competition, c.nom_competition, c.date_competition, c.lieu, cat.nom_categorie, t.nom_type, c.nb_equipes
        FROM competition c
        JOIN categorie cat ON c.categorie_id = cat.id_categorie
        JOIN type_competition t ON c.type_id = t.id_type
        ORDER BY c.date_competition DESC
	");
	$competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($competitions);
} elseif ($method === 'POST') {
    // Vérification des champs attendus
    if (isset($_POST['nom_competition'], $_POST['date_competition'], $_POST['lieu'], $_POST['categorie_id'], $_POST['type_id'], $_POST['nb_equipes'])) {
        // Récupération des données du formulaire
		$nom = $_POST['nom_competition'];
		$date = $_POST['date_competition'];
		$lieu = $_POST['lieu'];
		$categorie = $_POST['categorie_id'];
		$type = $_POST['type_id'];
		$nb_equipes = $_POST['nb_equipes'];
		$description = $_POST['description'];

        try {
            // Exécution de la procédure stockée (MySQL gère tout automatiquement)
			$stmt = $pdo->prepare("CALL creer_competition(?, ?, ?, ?, ?, ?, ?)");
			$stmt->execute([$nom, $date, $lieu, $categorie, $type, $nb_equipes, $description]);

            echo json_encode(['success' => true, 'message' => 'Compétitions ajouté avec succès.']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

    } else {
		echo json_encode(['error' => 'Champs manquants']);
	}
} else {
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
} 