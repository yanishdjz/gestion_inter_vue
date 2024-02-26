<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_inter";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log('Connexion à la base de données réussie.');
} catch (PDOException $e) {
    error_log('La connexion à la base de données a échoué : ' . $e->getMessage());
    die('La connexion à la base de données a échoué.');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:8080');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get_users') {
        try {
            $stmt = $pdo->query('SELECT * FROM users');
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des utilisateurs: ' . $e->getMessage()]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
    //$data = json_decode(file_get_contents('php://input'), true);
    $data = $_POST ;
    var_dump($data);

    if (empty($data['name']) || empty($data['email']) || empty($data['password']) || empty($data['phone_number']) || empty($data['vehicle_information'])) {
        echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
        exit;
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone_number, vehicle_information, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$data['name'], $data['email'], $hashedPassword, $data['phone_number'], $data['vehicle_information']]);
        echo json_encode(['success' => true, 'message' => 'Inscription réussie.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion : ' . $e->getMessage()]);
    }

    exit;
}

$pdo = null;
?>