<?php
include "config.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id, nome FROM usuarios WHERE email = '$email' AND senha = '$senha'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_nome'] = $user['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];
    header("Location: index.php"); // Redireciona para a área logada
} else {
    echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='login.php';</script>";
}
?>