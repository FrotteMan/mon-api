<?php
require 'connexion.php'; // Connexion à la base de données
header('Content-Type: application/json');

// Vérification que la méthode est POST
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Vérifier si les paramètres sont présents
    if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Requête pour récupérer l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Si la connexion est réussie, renvoyer les informations de l'utilisateur
            echo json_encode([
                'success' => true,
                'user_id' => $user['id'],
                'role' => $user['role'],
                'nom' => $user['nom']
            ]);
        } else {
            // Si la connexion échoue, renvoyer un message d'erreur
            echo json_encode(['error' => 'Email ou mot de passe incorrect.']);
        }
    } else {
        // Si les paramètres ne sont pas fournis
        echo json_encode(['error' => 'Paramètres manquants']);
    }
} else {
    // Si la méthode n'est pas POST
    http_response_code(405); // Méthode non autorisée
    echo json_encode(['error' => 'Méthode non autorisée']);
}
