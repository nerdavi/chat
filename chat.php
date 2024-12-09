<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirecionar para o login se não estiver logado
    exit;
}

include 'db.php';

$stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Div de Boas-vindas -->
<div id="welcome-container">
    <p>Bem-vindo, <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
    <a href="login.php" id="logout-btn">Logout</a>
</div>

<div id="chat-container">
    <div id="messages">
        <!-- Mensagens serão carregadas aqui -->
    </div>
    <form id="chat-form">
        <textarea id="message-text" placeholder="Digite sua mensagem..." required></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Função para carregar as mensagens
function loadMessages() {
    $.ajax({
        url: 'load_messages.php',
        method: 'GET',
        success: function(response) {
            $('#messages').html(response); // Carregar as mensagens
            $('#messages').scrollTop($('#messages')[0].scrollHeight); // Rolar para o final (última mensagem)
        }
    });
}

// Recarregar as mensagens ao carregar a página
loadMessages();

// Recarregar as mensagens a cada 2 segundos

// Enviar mensagem
$('#chat-form').on('submit', function(e) {
    e.preventDefault();
    const messageText = $('#message-text').val();

    if (messageText) {
        $.ajax({
            url: 'send_message.php',
            method: 'POST',
            data: { message: messageText },
            success: function() {
                $('#message-text').val(''); // Limpar o campo de texto
                loadMessages();  // Recarregar as mensagens após enviar
            }
        });
    }
});
</script>

</body>
</html>
