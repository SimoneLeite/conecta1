<?php
session_start();

// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o usuário está logado e é orientador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'Orientador') {
    die("Acesso negado.");
}

// Conexão com o banco de dados
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "fatecconecta";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro: A conexão com o banco de dados não foi estabelecida.");
}

// Inclui as bibliotecas FPDF e FPDI
require_once __DIR__ . '/../fpdf/fpdf.php';
require_once __DIR__ . '/../fpdi/FPDI-master/src/autoload.php'; // Ajuste o caminho se necessário

use setasign\Fpdi\Fpdi;

// Verifica se o ID do projeto foi enviado corretamente
if (!isset($_GET['id_projeto']) || empty($_GET['id_projeto'])) {
    die("ID do projeto não fornecido.");
}
$id_projeto = intval($_GET['id_projeto']);

// Consulta os dados do projeto
$sql = "
    SELECT p.tema, p.orientador, e.nome_evento, 
           a1.nome_alu AS aluno1, a2.nome_alu AS aluno2, a3.nome_alu AS aluno3, 
           a4.nome_alu AS aluno4, a5.nome_alu AS aluno5
    FROM projeto p
    LEFT JOIN eventos e ON p.id_evento = e.id_evento
    LEFT JOIN alunos a1 ON p.id_alu = a1.id_alu
    LEFT JOIN alunos a2 ON p.aluno2 = a2.id_alu
    LEFT JOIN alunos a3 ON p.aluno3 = a3.id_alu
    LEFT JOIN alunos a4 ON p.aluno4 = a4.id_alu
    LEFT JOIN alunos a5 ON p.aluno5 = a5.id_alu
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

// Monta a lista de alunos
$alunos = array_filter([
    $dados['aluno1'], $dados['aluno2'], $dados['aluno3'], 
    $dados['aluno4'], $dados['aluno5']
]);

$nomes_alunos = implode(", ", $alunos);
$tema_projeto = $dados['tema'];
$orientador = $dados['orientador'];
$evento = $dados['nome_evento'];
$data_atual = date("d") . " de " . date("F") . " de " . date("Y");

// Caminho do modelo de certificado
$modelo_certificado = __DIR__ . '/../fpdi/FPDI-master/certificado.pdf';

// Verifica se o arquivo de modelo existe
if (!file_exists($modelo_certificado)) {
    die("Erro: O modelo de certificado não foi encontrado.");
}

// Carrega o modelo de certificado existente
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile($modelo_certificado);
$template = $pdf->importPage(1);
$pdf->useTemplate($template, 0, 0, 210); // Ajusta ao tamanho A4

// Define a fonte para adicionar os textos
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);

// Adiciona os textos dinâmicos no certificado
$pdf->SetXY(30, 120); // Ajuste a posição conforme necessário
$pdf->MultiCell(150, 10, utf8_decode("Certificamos que os alunos $nomes_alunos, sob orientação de $orientador, participaram do evento $evento apresentando o projeto \"$tema_projeto\"."), 0, 'C');

$pdf->SetXY(30, 160);
$pdf->Cell(150, 10, utf8_decode("Araçatuba, $data_atual"), 0, 1, 'C');

// Salvar o novo certificado na pasta certificados
$certificado_path = "../certificados/certificado_$id_projeto.pdf";
$pdf->Output($certificado_path, 'F');

// Atualizar o banco de dados com o caminho do certificado
$sql_update = "UPDATE projeto SET certificado = ? WHERE id_pro = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("si", $certificado_path, $id_projeto);
$stmt->execute();

// Exibir o certificado gerado no navegador
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($certificado_path) . '"');
readfile($certificado_path);
exit;
?>



