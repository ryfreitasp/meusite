<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta | Nito Play</title>
</head>
<body style="background:#0f0f0f;color:#fff;font-family:Arial;display:flex;justify-content:center;align-items:center;height:100vh">

<div style="background:#1c1c1c;padding:30px;border-radius:12px;width:350px">
    <h2 style="text-align:center">Criar Conta</h2>

    <form action="cadastro_processa.php" method="POST">
        <input type="text" name="nome" placeholder="Nome" required style="width:100%;padding:12px;margin-bottom:10px">
        <input type="email" name="email" placeholder="E-mail" required style="width:100%;padding:12px;margin-bottom:10px">
        <input type="password" name="senha" placeholder="Senha" required style="width:100%;padding:12px;margin-bottom:10px">
        <button style="width:100%;padding:12px;background:#7c3aed;color:#fff;border:none">Cadastrar</button>
    </form>

    <p style="text-align:center;margin-top:10px">
        <a href="login.php" style="color:#a78bfa">Já tenho conta</a>
    </p>
</div>

</body>
</html>
