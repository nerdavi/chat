<?php
include 'db.php';

$stmt = $pdo->query("SELECT m.message_text, m.created_at, u.username
                     FROM messages m
                     JOIN users u ON m.user_id = u.user_id
                     ORDER BY m.created_at"); 

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    // Formatar a data para o formato desejado
    $data_formatada = date('d/M \à\s H:i', strtotime($message['created_at']));
    
    // Exibir as mensagens com a data formatada
    echo "<div class='message'>";
    echo "<strong>{$message['username']}</strong> <span class='timestamp'>($data_formatada)</span>";
    echo "<p>{$message['message_text']}</p>";
    echo "</div>";
}
?>
