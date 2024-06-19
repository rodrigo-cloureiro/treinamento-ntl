<?php


// include "repositorio.php";

// //initilize the page
// require_once("inc/init.php");
// //require UI configuration (nav, ribbon, etc.)
// require_once("inc/config.ui.php");
// require('./fpdf/mc_table.php');

// require_once('fpdf/fpdf.php');

// session_start();

// // $params = explode('?', $_SERVER['REQUEST_URI']);

// $sql = "SELECT codigo, nome, cpf, dataNascimento FROM funcionarios";

// $reposit = new reposit();
// $result = $reposit->RunQuery($sql);
// $out = "";

// $pdf = new FPDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
// $pdf->SetMargins(5, 10, 5); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
// $pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
// $pdf->AddPage();

// $pdf->SetFont('Arial', '', 10);
// $pdf->SetLeftMargin(10);
// $pdf->SetFont('Times', 'B', 18);
// $pdf->Cell(193, 5, iconv('UTF-8', 'windows-1252', "Requisição e Entrega de Uniforme e EPI"), 0, 0, "C", 0);
// $pdf->Ln(12);
// $pdf->Line(5, 35, 205, 35); #Primeira Linha na Horizontal

// $pdf->Ln(5);
// $pdf->SetX(110);
// $pdf->Ln(8);
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Ln(3);
// $pdf->Multicell(0, 4, iconv('UTF-8', 'windows-1252', "Declaro ter recebido da empresa NTL NOVA TECNOLOGIA LTDA, inscrita no CNPJ sob o n.º
// 32.185.480/0001-07 os itens abaixo discriminados, me comprometendo a utilizá-lo somente para fins
// laborais durante toda a jornada de trabalho e devolve-lo no término do contrato de trabalho, sob pena
// de se não o fizer, ser enquadrado em punições disciplinares"), 0, 'C');

// $pdf->Ln(12);
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Ln(8);
// $pdf->SetFillColor(234, 234, 234);
// $pdf->SetFont('Arial', 'B', 8);
// $pdf->Ln(5);

// $pdf->SetX(38);

// $pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', "Código"), 1, 0, "C", true);
// $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', 'Nome.'), 1, 0, "C", true);
// $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', 'Data de Nascimento.'), 1, 0, "C", true);
// $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', 'CPF.'), 1, 0, "C", true);

// $pdf->Ln();

// $pdf->SetFont('Arial', '', 8);
// $contador = 0;

// $linha = $pdf->Ultimalinha();
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Line(5, $linha, 205, $linha); #Quinta Linha na Horizontal
// $pdf->Ln(6);

// $linha = $pdf->Ultimalinha();
// $pdf->Ln(2);

// $pdf->Setx(140);
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(28, 5, iconv('UTF-8', 'windows-1252', "Rio de Janeiro : "), 0, 0, "L", 0);
// $pdf->SetFont('Arial', '', 10);
// $dataAtual = date('d/m/Y');
// $pdf->Cell(2, 5, iconv('UTF-8', 'windows-1252', $dataAtual), 0, 0, "L", 0);
// $pdf->Ln(10);

// $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', "Código"), 1, 0, "C", true);
// $pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', 'Nome.'), 1, 0, "C", true);
// $pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', 'Data de Nascimento.'), 1, 0, "C", true);
// $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', 'CPF.'), 1, 0, "C", true);
// $pdf->Ln(10);

// if ($result) {
//     foreach ($result as $row) {
//         $codigo = $row['codigo'];
//         $nomeCompleto = $row['nome'];
//         $cpf = $row['cpf'];
//         $dataNascimento = $row['dataNascimento'];

//         $pdf->Cell(20, 6, iconv('UTF-8', 'windows-1252', $codigo), 1, 0, "C", true);
//         $pdf->Cell(100, 6, iconv('UTF-8', 'windows-1252', $nomeCompleto), 1, 0, "C", true);
//         $pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', $dataNascimento), 1, 0, "C", true);
//         $pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', $cpf), 1, 0, "C", true);

//         $pdf->Ln(8);
//         $pdf->Ln();
//     }
// }

// $pdf->Ln(8);

// $pdf->Output();

include "repositorio.php";
require_once("inc/init.php");
require_once("inc/config.ui.php");
require('./fpdf/mc_table.php');
require_once('fpdf/fpdf.php');

session_start();

// $params = explode('/', $_SERVER['QUERY_STRING']);

$sql = "SELECT f.ativo, nome, cpf, dataNascimento, ec.descricao, s.descricao AS sexo
        FROM funcionarios f
            JOIN estado_civil ec ON f.estadoCivil = ec.codigo
            JOIN sexo s ON f.genero = s.codigo
        WHERE f.ativo = 1 ";

// if (count($params) > 0) {
//     foreach ($params as $filters) {
//         $filters = explode('=', $filters);
//         if ($filters[0] === 'sexo') {
//             $where = 'AND s.descricao = ' . "'" . $filters[1] . "'";
//         }
//         if ($filters[0] === 'estadoCivil') {
//             $where = 'AND ec.descricao = ' . "'" . $filters[1] . "'";
//         }
//     }
//     $sql .= $where;
// }

$reposit = new reposit();
$result = $reposit->RunQuery($sql);

class PDF extends FPDF
{
    // function Header() {
    //     $date = date('d/m/Y');

    //     $this->Image('./img/ntl-2.png', 10, 10, -1000);
    //     $this->SetFont('Arial', 'B', 17);
    //     $this->Cell(20);
    //     $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'Relatório de Funcionários'), 0, 0, 'C', 0);
    //     $this->Ln(6);
    //     $this->SetFont('Arial', 'I', 10);
    //     $this->Cell(20);
    //     $this->Cell(0, 10, iconv('UTF-8', 'windows-1252', $date), 0, 0, 'C', 0);
    //     $this->Line(5, 35, 205, 35);
    // }

    // function Footer()
    // {
    //     $this->SetY(-20);
    //     $this->SetFont('Arial', 'I', 8);
    //     $this->Cell(0, 38, 'Page' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    // }
}

$pdf = new FPDF('P', 'cm', 'A4');
$pdf->SetMargins(1, 2, 1);
$pdf->AddPage();

$date = date('d/m/Y');

$pdf->Image('./img/ntl-2.png', 0.8, 0.25, -1000);
$pdf->SetFont('Arial', 'B', 17);
$pdf->Cell(0, -2, iconv('UTF-8', 'windows-1252', 'Relatório de Funcionários'), 0, 0, 'C', 0);
$pdf->Ln(0.5);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, -2, iconv('UTF-8', 'windows-1252', $date), 0, 0, 'C', 0);
$pdf->Ln(1);

// $pdf->SetFont('Arial', 'B', 10);
// $pdf->SetFillColor(144, 148, 152);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell(1.1, 1, 'Ativo', 1, 0, 'C', true);
// $pdf->Cell(2.7, 1, 'CPF', 1, 0, 'C', true);
// $pdf->Cell(9, 1, 'Nome', 1, 0, 'C', true);
// $pdf->Cell(3.6, 1, 'Data de Nascimento', 1, 0, 'L', true);
// $pdf->Cell(2.5, 1, 'Estado Civil', 1, 1, 'L', true);

$y = $pdf->GetY() + 1.5;
array_push($result, ...$result);
foreach ($result  as $index => $row) {
    $dataNasc = (new DateTime($row['dataNascimento']))->format('d/m/Y');

    // $pdf->SetFont('Arial', '', 10);
    // $pdf->SetTextColor(0, 0, 0);
    // $pdf->Cell(1.1, 1, iconv('UTF-8', 'windows-1252', ($row['ativo'] == 1 ? 'Sim' : "Não")), 1, 0, 'C');
    // $pdf->Cell(2.7, 1, $row['cpf'], 1, 0, 'C');
    // $pdf->Cell(9, 1, iconv('UTF-8', 'windows-1252', $row['nome']), 1, 0, 'L');
    // $pdf->Cell(3.6, 1, $dataNasc, 1, 0, 'L');
    // $pdf->Cell(2.5, 1, ucfirst($row['descricao']), 1, 1, 'L');
    // $pdf->Ln(0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(144, 148, 152);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($pdf->GetPageWidth() - 2, 1,  iconv('UTF-8', 'windows-1252', 'Nome: ' . $row['nome']), 1, 0, 'L', true);
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($pdf->GetPageWidth() - 2, 2.3, '', 1, 0, 'L');
    $pdf->Text(1.1, $y, 'CPF: ' . $row['cpf']);
    $pdf->Text(1.1, $y += 0.5, 'Data de Nascimento: ' . $dataNasc);
    $pdf->Text(1.1, $y += 0.5, 'Estado Civil: ' . ucfirst($row['descricao']));
    $pdf->Text(1.1, $y += 0.5, 'Sexo: ' . ucfirst($row['sexo']));
    $pdf->Ln(3);

    if ($index > 0 && $index < 6 && $index % 5 == 0) {
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false, 0);
        $y = $pdf->GetY() + 1.5;
    } else if ($index > 0 && ($index + 1) % 6 == 0) {
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false, 0);
        $y = $pdf->GetY() + 1.5;
    } else {
        $y += 2.5;
    }

    $pdf->SetAutoPageBreak(true, 2);
}

// $pdf->SetFont('Arial', 'B', 10);
// $pdf->SetFillColor(144, 148, 152);
// $pdf->SetTextColor(255, 255, 255);
// $pdf->Cell($pdf->GetPageWidth() / 2 - 2, 1, 'Nome: ' . $row['nome'], 1, 0, 'L', true);
// $pdf->Ln(1);
// $pdf->SetTextColor(0, 0, 0);
// $pdf->Cell($pdf->GetPageWidth() / 2 - 2, 2.3, '', 1, 0, 'L');
// $pdf->Text(1.1, 5, 'CPF: ' . $row['cpf']);
// $pdf->Text(1.1, 5.5, 'Data de Nascimento: ' . $dataNasc);
// $pdf->Text(1.1, 6, 'Estado Civil: ' . ucfirst($row['descricao']));
// $pdf->Text(1.1, 6.5, 'Sexo: ' . ucfirst($row['sexo']));
// $pdf->Ln(0.5);
// $pdf->Cell($pdf->GetPageWidth() - 2, 1, 'CPF: ' . $row['cpf'], 0, 0, 'L');
// $pdf->Ln(0.5);
// $pdf->Cell($pdf->GetPageWidth() - 2, 1, 'Data de Nascimento: ' . $dataNasc, 0, 0, 'L');
// $pdf->Ln(0.5);
// $pdf->Cell($pdf->GetPageWidth() - 2, 1, 'Estado Civil: ' . ucfirst($row['descricao']), 0, 0, 'L');
// $pdf->Ln(0.5);
// $pdf->Cell($pdf->GetPageWidth() - 2, 1, 'Sexo: ' . ucfirst($row['sexo']), 0, 0, 'L');
// $pdf->Ln(0.5);

$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 11);
$pdf->Output();
