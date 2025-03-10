<?php
session_start();

// Verifica se o usuário está logado e é orientador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'Orientador') {
    die("Acesso negado.");
}

// Exibir erros para depuração (opcional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados.");
}

// Inclui a biblioteca FPDF (ajuste o caminho conforme sua pasta)
require_once __DIR__ . '/../fpdf/fpdf.php';

// Verifica se o ID do projeto foi enviado
if (!isset($_GET['id_projeto']) || empty($_GET['id_projeto'])) {
    die("ID do projeto não fornecido.");
}
$id_projeto = intval($_GET['id_projeto']);

// Consulta os dados do projeto (tema, orientador, evento, alunos)
$sql = "
    SELECT 
        p.tema,
        p.orientador,
        e.nome_evento,
        a1.nome_alu AS aluno1,
        a2.nome_alu AS aluno2,
        a3.nome_alu AS aluno3,
        a4.nome_alu AS aluno4,
        a5.nome_alu AS aluno5
    FROM projeto p
    LEFT JOIN eventos e ON p.id_evento = e.id_evento
    LEFT JOIN alunos a1 ON p.id_alu   = a1.id_alu
    LEFT JOIN alunos a2 ON p.aluno2   = a2.id_alu
    LEFT JOIN alunos a3 ON p.aluno3   = a3.id_alu
    LEFT JOIN alunos a4 ON p.aluno4   = a4.id_alu
    LEFT JOIN alunos a5 ON p.aluno5   = a5.id_alu
    WHERE p.id_pro = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_projeto);
$stmt->execute();
$result = $stmt->get_result();
$dados = $result->fetch_assoc();

if (!$dados) {
    die("Projeto não encontrado.");
}

// Monta a lista de alunos (ignorando nulos/vazios)
$alunos = array_filter([
    $dados['aluno1'],
    $dados['aluno2'],
    $dados['aluno3'],
    $dados['aluno4'],
    $dados['aluno5']
]);
$nomes_alunos   = implode(", ", $alunos);
$tema_projeto   = $dados['tema'];
$orientador     = $dados['orientador'];
$evento         = $dados['nome_evento'];

// Formata data (ex.: "10 de março de 2025")
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8');
date_default_timezone_set('America/Sao_Paulo');
$data_atual = strftime('%d de %B de %Y');

// Campos de assinatura: nome e cargo
//    - Valores padrão
$assinaturaNomePadrao  = "Prof. Dr. Giuliano Pierre Estevam";
$assinaturaCargoPadrao = "Diretor";

//    - Se quiser permitir que venham via GET, por exemplo:
//      gerar_certificado.php?id_projeto=5&nome_assinatura=Fulano&cargo_assinatura=Coordenador
$assinaturaNome = isset($_GET['nome_assinatura']) && !empty($_GET['nome_assinatura'])
    ? $_GET['nome_assinatura']
    : $assinaturaNomePadrao;

$assinaturaCargo = isset($_GET['cargo_assinatura']) && !empty($_GET['cargo_assinatura'])
    ? $_GET['cargo_assinatura']
    : $assinaturaCargoPadrao;

// Cria o PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

//  Inserir logos (ajuste posições se necessário)
$pdf->Image(__DIR__ . '/../img/logo_certificado.png', 10, 10, 30);
$pdf->Image(__DIR__ . '/../img/logo_cps.png', 75, 10, 30);
$pdf->Image(__DIR__ . '/../img/lodo_governo.png', 140, 10, 30);

// Reduz espaço se estiver “quebrando” página
$pdf->Ln(30);

//  Título
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 10, utf8_decode('CERTIFICADO'), 0, 1, 'C');
$pdf->Ln(5);

//  Texto principal
$pdf->SetFont('Arial', '', 12);
$texto = "Certificamos que os(as) seguintes alunos(as): $nomes_alunos\n"
       . "sob orientação de $orientador, participaram do evento '$evento' "
       . "apresentando o projeto \"$tema_projeto\".\n\n"
       . "Este certificado é concedido pela Fatec Conecta como comprovação de participação, "
       . "com carga horária de 20 horas.\n\n"
       . "Araçatuba, $data_atual.";

$pdf->MultiCell(0, 6, utf8_decode($texto), 0, 'J');
$pdf->Ln(10);

// Assinatura
// - Se a imagem da assinatura for grande, tente colocar em Y=180 ou 190 para caber
$pdf->Image(__DIR__ . '/../img/logo_assinatura.png', 80, 180, 50);

// Texto abaixo da assinatura
// Ajuste a posição final para não quebrar a página
$pdf->SetXY(10, 240);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, utf8_decode($assinaturaNome), 0, 1, 'C');
$pdf->Cell(0, 6, utf8_decode($assinaturaCargo), 0, 1, 'C');

//  Salva o PDF em /certificados
$certificado_path_abs = __DIR__ . '/../certificados/certificado_' . $id_projeto . '.pdf';
$pdf->Output($certificado_path_abs, 'F');  // 'F' = salva no servidor

// Caminho relativo para salvar no banco (opcional)
$certificado_path_rel = 'certificados/certificado_' . $id_projeto . '.pdf';

// Atualiza o campo "certificado" no banco
$sql_update = "UPDATE projeto SET certificado = ? WHERE id_pro = ?";
$stmt2 = $conn->prepare($sql_update);
$stmt2->bind_param("si", $certificado_path_rel, $id_projeto);
$stmt2->execute();

// Exibe o PDF no navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($certificado_path_rel) . '"');
readfile(__DIR__ . '/../' . $certificado_path_rel);

$conn->close();
exit;
?>

