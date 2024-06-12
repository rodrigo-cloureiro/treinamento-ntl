<?php

include "repositorio.php";

//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
require('./fpdf/mc_table.php');

require_once('fpdf/fpdf.php');

session_start();

// $params = explode('?', $_SERVER['REQUEST_URI']);

$sql = "SELECT codigo, nome, cpf, dataNascimento FROM funcionarios";

$reposit = new reposit();
$result = $reposit->RunQuery($sql);
$out = "";

$pdf = new FPDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetMargins(5, 10, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->AddPage();

$pdf->SetFont('Arial', '', 10);
$pdf->SetLeftMargin(10);
$pdf->SetFont('Times', 'B', 18);
$pdf->Cell(193, 5, iconv('UTF-8', 'windows-1252', "Requisição e Entrega de Uniforme e EPI"), 0, 0, "C", 0);
$pdf->Ln(12);
$pdf->Line(5, 35, 205, 35); #Primeira Linha na Horizontal

$pdf->Ln(5);
$pdf->SetX(110);
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(3);
$pdf->Multicell(0, 4, iconv('UTF-8', 'windows-1252', "Declaro ter recebido da empresa NTL NOVA TECNOLOGIA LTDA, inscrita no CNPJ sob o n.º
32.185.480/0001-07 os itens abaixo discriminados, me comprometendo a utilizá-lo somente para fins
laborais durante toda a jornada de trabalho e devolve-lo no término do contrato de trabalho, sob pena
de se não o fizer, ser enquadrado em punições disciplinares"), 0, 'C');

$pdf->Ln(12);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(8);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(5);

$pdf->SetX(38);

$pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Descrição"), 1, 0, "C", true);
$pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', 'Qtd.'), 1, 0, "C", true);

$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$contador = 0;

$linha = $pdf->Ultimalinha();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Line(5, $linha, 205, $linha); #Quinta Linha na Horizontal
$pdf->Ln(6);

$linha = $pdf->Ultimalinha();
$pdf->Ln(2);

$pdf->Setx(140);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv('UTF-8', 'windows-1252', "Rio de Janeiro : "), 0, 0, "L", 0);
$pdf->SetFont('Arial', '', 10);
$dataAtual = date('d/m/Y');
$pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $dataAtual), 0, 0, "L", 0);
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(80, 5, iconv('UTF-8', 'windows-1252', "Assinatura:_____________________________________________________"), 0, 0, "L", 0);

if ($result) {
    foreach ($result as $row) {
        $codigo = $row['codigo'];
        $nomeCompleto = $row['nome'];
        $cpf = $row['cpf'];
        $dataNascimento = $row['dataNascimento'];

        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(12, 5, iconv('UTF-8', 'windows-1252', "Nome: "), 0, 0, "L", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $nomeCompleto), 0, 0, "L", 0);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(18, 5, iconv('UTF-8', 'windows-1252', "Matricula:"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $codigo), 0, 0, "L", 0);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "CPF:"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0);
        $pdf->Ln(8);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(36, 5, iconv('UTF-8', 'windows-1252', "Data de Nascimento:"), 0, 0, "L", 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $dataNascimento), 0, 0, "L", 0);
        $pdf->Ln(8);

        $pdf->SetFillColor(234, 234, 234);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Ln();
    }
}

$pdf->Ln(8);

$pdf->Output();
