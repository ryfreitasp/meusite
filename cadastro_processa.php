<?php
include "config.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha']; // Em um site real, usaríamos password_hash aqui por segurança

$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.php';</script>";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>