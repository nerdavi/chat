<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);  // Hash da senha

    // Verificar se o nome de usuário ou email já existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        $message = "Usuário ou email já existe.";
        $messageClass = 'error';
    } else {
        // Inserir o novo usuário no banco
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        if ($stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $passwordHash])) {
            $message = "Cadastro realizado com sucesso!";
            $messageClass = 'success';
        } else {
            $message = "Erro ao cadastrar usuário.";
            $messageClass = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para o arquivo de estilo -->
</head>
<body>

    <div id="register-container">
        <h1>Registrar</h1>
        
        <!-- Exibir mensagem de sucesso ou erro -->
        <?php if (isset($message)): ?>
            <div id="message" class="<?php echo $messageClass; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Formulário de Registro -->
        <form action="register.php" method="POST">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Cadastrar</button>
        </form>
        
        <!-- Link para a página de login -->
        <a href="login.php">Já tem uma conta? Faça login</a>
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

/* Container do formulário de registro */
#register-container {
    width: 100%;
    max-width: 400px;
    background-color: white;
    padding: 30px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Título do formulário */
#register-container h1 {
    font-size: 1.8em;
    color: #1e3a5f; /* Azul escuro */
    margin-bottom: 20px;
}

/* Estilo dos campos de entrada */
input[type="text"], input[type="email"], input[type="password"] {
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

/* Link de "Já tem conta?" */
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

/* Estilo de mensagem de erro ou sucesso */
#message {
    font-size: 14px;
    margin-top: 15px;
}

#message.success {
    color: #27ae60; /* Verde para sucesso */
}

#message.error {
    color: #e74c3c; /* Vermelho para erro */
}

/* Responsividade */
@media (max-width: 768px) {
    #register-container {
        width: 90%;
    }

    button, input[type="text"], input[type="email"], input[type="password"] {
        font-size: 13px;
    }
}

</style>

</html>
