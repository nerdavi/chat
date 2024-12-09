<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar o usuário pelo email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id']; // Guardar o ID do usuário na sessão
        header("Location: chat.php"); // Redirecionar para o chat
        exit;
    } else {
        $error_message = "Email ou senha inválidos.";
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para o arquivo de estilo -->
</head>
<body>

    <div id="login-container">
        <h1>Login</h1>
        
        <!-- Exibir mensagem de erro -->
        <?php if (isset($error_message)): ?>
            <div id="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Formulário de Login -->
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Entrar</button>
        </form>
        
        <!-- Link para página de registro -->
        <a href="register.php">Não tem conta? Registre-se</a>
    </div>

</body>

<style>
    /* Reset de margens e padding para garantir consistência */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilos gerais do body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #e8f4f9; /* Cor de fundo suave em tom de azul claro */
    color: #333; /* Cor do texto */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

/* Container do formulário de login */
#login-container {
    width: 100%;
    max-width: 400px;
    background-color: white;
    padding: 30px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Título do formulário */
#login-container h1 {
    font-size: 1.8em;
    color: #1e3a5f; /* Azul escuro */
    margin-bottom: 20px;
}

/* Estilo dos campos de entrada */
input[type="email"], input[type="password"] {
    width: 100%;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 15px;
    background-color: #f4f8ff; /* Azul claro */
}

/* Estilo do botão */
button {
    width: 100%;
    padding: 12px;
    background-color: #1e3a5f; /* Azul escuro */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4b6a8c; /* Azul médio para hover */
}

button:active {
    background-color: #36557b; /* Azul escuro para click */
}

/* Link de "Registrar" */
a {
    display: block;
    margin-top: 15px;
    text-align: center;
    font-size: 14px;
    color: #1e3a5f;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Estilo de mensagem de erro */
#error-message {
    color: #e74c3c; /* Vermelho */
    font-size: 14px;
    margin-top: 15px;
}

/* Responsividade */
@media (max-width: 768px) {
    #login-container {
        width: 90%;
    }

    button, input[type="email"], input[type="password"] {
        font-size: 13px;
    }
}

</style>
</html>
