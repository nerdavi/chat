<?php
$host = 'localhost'; // Altere para o seu host do banco de dados
$dbname = 'chat'; // Altere para o nome do seu banco de dados
$user = 'postgres'; // Altere para o seu usuário
$pass = '1234'; // Altere para sua senha

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
