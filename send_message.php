<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die('Você precisa estar logado para enviar mensagens.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageText = $_POST['message'];
    $userId = $_SESSION['user_id'];

    if ($messageText) {
        // Inserir a mensagem no banco de dados
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, message_text) VALUES (:user_id, :message_text)");
        $stmt->execute(['user_id' => $userId, 'message_text' => $messageText]);
    }
}
?>
