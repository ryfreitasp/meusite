<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Entrar | Nito Play</title>
    <style>
        body {
            background: #0f0f0f;
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: #1c1c1c;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
            border: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #7c3aed;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            color: #a78bfa;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Entrar</h2>

    <form action="login_processa.php" method="POST">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <div class="link">
        <p>Não tem conta? <a href="cadastro.php">Criar conta</a></p>
    </div>
</div>

</body>
</html>
