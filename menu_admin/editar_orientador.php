<?php
include '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conexao->prepare("SELECT * FROM orientadores WHERE id_ori = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $orientador = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$orientador) {
        die("Orientador não encontrado!");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome_ori']);
    $cpf = trim($_POST['cpf_ori']);
    $email = trim($_POST['email_ori']);
    $fone = trim($_POST['fone_ori']);
    $novaSenha = trim($_POST['senha_ori']);

    if (!empty($nome) && !empty($cpf) && !empty($email) && !empty($fone)) {
        if (!empty($novaSenha)) {
            // Se o usuário digitou uma nova senha, atualizar com hash seguro
            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $stmt = $conexao->prepare("UPDATE orientadores SET nome_ori = :nome, cpf_ori = :cpf, email_ori = :email, fone_ori = :fone, senha_ori = :senha WHERE id_ori = :id");
            $stmt->bindParam(':senha', $senhaHash);
        } else {
            // Manter a senha antiga se o campo estiver vazio
            $stmt = $conexao->prepare("UPDATE orientadores SET nome_ori = :nome, cpf_ori = :cpf, email_ori = :email, fone_ori = :fone WHERE id_ori = :id");
        }

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fone', $fone);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: listar_orientadores.php");
            exit();
        } else {
            $error = "Erro ao atualizar o orientador!";
        }
    } else {
        $error = "Todos os campos são obrigatórios!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orientador</title>
    <link rel="stylesheet" href="../css/orientador.css">
    <script>
        function aplicarMascaraCPF(campo) {
            campo.value = campo.value.replace(/\D/g, "")
                                      .replace(/(\d{3})(\d)/, "$1.$2")
                                      .replace(/(\d{3})(\d)/, "$1.$2")
                                      .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        }

        function aplicarMascaraTelefone(campo) {
            campo.value = campo.value.replace(/\D/g, "")
                                      .replace(/(\d{2})(\d)/, "($1) $2")
                                      .replace(/(\d{4,5})(\d{4})$/, "$1-$2");
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Editar Orientador</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nome_ori">Nome:</label>
            <input type="text" id="nome_ori" name="nome_ori" value="<?= htmlspecialchars($orientador['nome_ori']); ?>" required>

            <label for="cpf_ori">CPF:</label>
            <input type="text" id="cpf_ori" name="cpf_ori" value="<?= htmlspecialchars($orientador['cpf_ori']); ?>" maxlength="14" oninput="aplicarMascaraCPF(this)" required>

            <label for="email_ori">E-mail:</label>
            <input type="email" id="email_ori" name="email_ori" value="<?= htmlspecialchars($orientador['email_ori']); ?>" required>

            <label for="fone_ori">Telefone:</label>
            <input type="text" id="fone_ori" name="fone_ori" value="<?= htmlspecialchars($orientador['fone_ori']); ?>" maxlength="15" oninput="aplicarMascaraTelefone(this)" required>

            <label for="senha_ori">Nova Senha (opcional):</label>
            <input type="password" id="senha_ori" name="senha_ori" placeholder="Deixe em branco para manter a senha atual">

            <button type="submit" class="btn">Salvar Alterações</button>
            <a href="listar_orientadores.php" class="btn">Cancelar</a>
        </form>
    </div>
</body>
</html>



