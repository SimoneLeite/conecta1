<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fatecconecta";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_evento = $_POST['nome_evento'] ?? '';
    $evento_datainicio = $_POST['evento_datainicio'] ?? '';
    $evento_datafim = $_POST['evento_datafim'] ?? '';
    $horario_evento = $_POST['horario_evento'] ?? '';
    $local_evento = $_POST['local_evento'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    // 📌 Processamento da Imagem
    $imagemNome = $_FILES['imagem']['name'];
    $imagemTmp = $_FILES['imagem']['tmp_name'];
    $imagemNomeUnico = time() . "_" . basename($imagemNome);

    // Definir o diretório correto para salvar a imagem
    $diretorioDestino = "../menu_alunos/uploads/";
    if (!file_exists($diretorioDestino)) {
        mkdir($diretorioDestino, 0777, true);
    }

    $caminhoImagem = "menu_alunos/uploads/" . $imagemNomeUnico; // Caminho para ser salvo no banco
    $imagemDestino = $diretorioDestino . $imagemNomeUnico; // Caminho físico no servidor

    if (move_uploaded_file($imagemTmp, $imagemDestino)) {
        // ✅ Inserção no Banco de Dados (Salva o caminho correto)
        $sql = "INSERT INTO eventos (nome_evento, evento_datainicio, evento_datafim, horario_evento, local_evento, descricao, imagem) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nome_evento, $evento_datainicio, $evento_datafim, $horario_evento, $local_evento, $descricao, $caminhoImagem);

        if ($stmt->execute()) {
            echo "<script>alert('Evento cadastrado com sucesso!'); window.location.href='eventos.php';</script>";
        } else {
            echo "Erro ao cadastrar evento: " . $stmt->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}

$conn->close();
?>


