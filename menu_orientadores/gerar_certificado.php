<?php
require(__DIR__ . '/../fpdf/fpdf.php'); // Importa a biblioteca FPDF

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Teste de PDF');
$pdf->Output();

require('config.php'); // Conexão com o banco de dados

if (isset($_POST['id_projeto'])) {
    $idProjeto = $_POST['id_projeto'];

    // Consulta para obter os detalhes do projeto e alunos
    $sql = "
        SELECT 
            projeto.tema, projeto.orientador, eventos.nome_evento, 
            alunos.nome_alu AS aluno1, a2.nome_alu AS aluno2, 
            a3.nome_alu AS aluno3, a4.nome_alu AS aluno4, 
            a5.nome_alu AS aluno5
        FROM projeto
        LEFT JOIN alunos ON projeto.id_alu = alunos.id_alu
        LEFT JOIN alunos a2 ON projeto.aluno2 = a2.id_alu
        LEFT JOIN alunos a3 ON projeto.aluno3 = a3.id_alu
        LEFT JOIN alunos a4 ON projeto.aluno4 = a4.id_alu
        LEFT JOIN alunos a5 ON projeto.aluno5 = a5.id_alu
        LEFT JOIN eventos ON projeto.id_evento = eventos.id_evento
        WHERE projeto.id_pro = ?";
        
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProjeto);
    $stmt->execute();
    $result = $stmt->get_result();
    $dados = $result->fetch_assoc();

    if ($dados) {
        $alunos = array_filter([$dados['aluno1'], $dados['aluno2'], $dados['aluno3'], $dados['aluno4'], $dados['aluno5']]);
        $listaAlunos = implode(", ", $alunos);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('logo_fatec.png', 10, 10, 50); // Logotipo
        $pdf->Ln(30);
        $pdf->Cell(0, 10, "CERTIFICADO", 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, utf8_decode("Certificamos que os alunos(a): $listaAlunos participaram do evento {$dados['nome_evento']}, apresentando o trabalho intitulado '{$dados['tema']}', sob orientação de {$dados['orientador']}."));

        // Salvar certificado no servidor
        $caminhoCertificado = "certificados/certificado_$idProjeto.pdf";
        $pdf->Output($caminhoCertificado, 'F');

        // Atualizar no banco de dados
        $sqlUpdate = "UPDATE projeto SET certificado = ? WHERE id_pro = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $caminhoCertificado, $idProjeto);
        $stmtUpdate->execute();

        echo "<script>alert('Certificado gerado com sucesso!'); window.location.href='orientador_itens.php';</script>";
    } else {
        echo "<script>alert('Erro ao gerar certificado.'); history.back();</script>";
    }
}
?>
