<?php

include "repositorio.php";
require_once("inc/init.php");
require_once("inc/config.ui.php");
require('./fpdf/mc_table.php');
require_once('fpdf/fpdf.php');

session_start();

$id = explode('=', $_SERVER['QUERY_STRING'])[1];

$sql = "SELECT f.nome, f.cpf, f.rg, f.dataNascimento, s.descricao AS sexo,
	    ec.descricao, f.cep, f.logradouro, f.uf, f.bairro,
	    f.numero, f.complemento, f.primeiroEmprego, f.pispasep
        FROM funcionarios f
            JOIN sexo s ON f.genero = s.codigo
            JOIN estado_civil ec ON f.estadoCivil = ec.codigo
        WHERE f.codigo = $id ";

$reposit = new reposit();
$resultFuncionario = $reposit->RunQuery($sql);

$sql = "SELECT t.telefone, t.principal, t.whatsapp
        FROM funcionarios f
            JOIN telefones t ON f.codigo = t.funcionarioId
        WHERE f.codigo = $id ";

$reposit = new reposit();
$telefonesFuncionario = $reposit->RunQuery($sql);

$sql = "SELECT e.email, e.principal
        FROM funcionarios f
            JOIN emails e ON f.codigo = e.codigo_func
        WHERE f.codigo = $id ";

$reposit = new reposit();
$emailsFuncionario = $reposit->RunQuery($sql);

$sql = "SELECT d.nome, d.cpf, d.dataNascimento, td.descricao AS tipo_dep
        FROM funcionarios f
            JOIN dependentes d ON f.codigo = d.funcionarioId
            JOIN tipos_dependentes td ON d.tipo = td.codigo
        WHERE f.codigo = $id ";

$reposit = new reposit();
$dependentesFuncionario = $reposit->RunQuery($sql);

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
$pdf->Cell(0, -2, iconv('UTF-8', 'windows-1252', 'Relatório'), 0, 0, 'C', 0);
$pdf->Ln(0.5);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, -2, iconv('UTF-8', 'windows-1252', $date), 0, 0, 'C', 0);
$pdf->Ln(1);

$y = $pdf->GetY() + 1.5;
foreach ($resultFuncionario  as $index => $row) {
    $dataNasc = (new DateTime($row['dataNascimento']))->format('d/m/Y');

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(144, 148, 152);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($pdf->GetPageWidth() - 2, 1,  iconv('UTF-8', 'windows-1252', $row['nome']), 1, 0, 'L', true);
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Text(1.1, $y, 'CPF: ' . $row['cpf']);
    $pdf->Text(1.1, $y += 0.5, 'RG: ' . $row['rg']);
    $pdf->Text(1.1, $y += 0.5, 'Data de Nascimento: ' . $dataNasc);
    $pdf->Text(1.1, $y += 0.5, 'Estado Civil: ' . ucfirst($row['descricao']));
    $pdf->Text(1.1, $y += 0.5, 'Sexo: ' . ucfirst($row['sexo']));
    $pdf->Text(1.1, $y += 0.5, 'CEP: ' . iconv('UTF-8', 'windows-1252', $row['cep']));
    $pdf->Text(1.1, $y += 0.5, 'Logradouro: ' . iconv('UTF-8', 'windows-1252', $row['logradouro']));
    $pdf->Text(1.1, $y += 0.5, 'UF: ' . $row['uf']);
    $pdf->Text(1.1, $y += 0.5, 'Bairro: ' . iconv('UTF-8', 'windows-1252', $row['bairro']));
    $pdf->Text(1.1, $y += 0.5, iconv('UTF-8', 'windows-1252', 'Número: ' . $row['numero']));
    $pdf->Text(1.1, $y += 0.5, 'Complemento: ' . iconv('UTF-8', 'windows-1252', $row['complemento'] == '' ? 'Não possui' : $row['complemento']));
    $pdf->Text(1.1, $y += 0.5, iconv('UTF-8', 'windows-1252', 'Primeiro Emprego: ' . ($row['primeiroEmprego'] == 1 ? 'Sim' : 'Não')));
    $pdf->Text(1.1, $y += 0.5, iconv('UTF-8', 'windows-1252', 'PIS-PASEP: ' . ($row['pispasep'] != 'NULL' ? $row['pispasep'] : 'Não possui')));
    $pdf->Ln(3);

    if ($index > 0 && $index < 6 && $index % 5 == 0) {
        if (count($resultFuncionario) - 1 > $index) {
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false, 0);
            $y = $pdf->GetY() + 1.5;
        }
    } else if ($index > 0 && ($index + 1) % 6 == 0) {
        if (count($resultFuncionario) - 1 > $index) {
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false, 0);
            $y = $pdf->GetY() + 1.5;
        }
    } else {
        $y += 2.5;
    }
}

if (count($telefonesFuncionario) > 0 || count($emailsFuncionario) > 0) {
    $y = $pdf->GetY() + 5.5;
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(144, 148, 152);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($pdf->GetPageWidth() - 2, 1,  'Lista de contatos', 1, 0, 'L', true);
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 0, 0);

    if (count($telefonesFuncionario) > 0) {
        foreach ($telefonesFuncionario  as $index => $row) {
            $telefoneTexto = $row['principal'] == 1 ? 'Telefone Principal: ' . $row['telefone'] : 'Telefone ' . $index + 1 . ': ' . $row['telefone'];
            if ($row['whatsapp'] == 1) {
                $telefoneTexto .= '  |  ' . 'WhatsApp: Sim';
            }
            $pdf->Text(1.1, $y, iconv('UTF-8', 'windows-1252', $telefoneTexto));
            $y += 0.5;
        }
        $y += 0.5;
    }

    if (count($emailsFuncionario) > 0) {
        foreach ($emailsFuncionario  as $index => $row) {
            if ($row['principal'] == 1) {
                $pdf->Text(1.1, $y, 'Email Principal: ' . $row['email']);
            } else {
                $pdf->Text(1.1, $y, 'Email ' . $index + 1 . ': ' . $row['email']);
            }
            $y += 0.5;
        }
        $y += 0.5;
    }
}

if (count($dependentesFuncionario) > 0) {
    $y = $pdf->GetY();
    if (count($telefonesFuncionario) > 0 && count($emailsFuncionario) == 0) {
        $pdf->Ln(1 + (count($emailsFuncionario) - 1 + count($telefonesFuncionario)) * 0.5);
    } else if (count($emailsFuncionario) > 0 && count($telefonesFuncionario) == 0) {
        $pdf->Ln(1 + (count($emailsFuncionario) + count($telefonesFuncionario) - 1) * 0.5);
    } else {
        $pdf->Ln(1 + (count($emailsFuncionario) + count($telefonesFuncionario)) * 0.5);
    }
    // $pdf->Ln(1.5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(144, 148, 152);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($pdf->GetPageWidth() - 2, 1,  'Lista de dependentes', 1, 0, 'L', true);
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 0, 0);

    $y = $pdf->GetY(); 
    foreach ($dependentesFuncionario  as $index => $row) {
        $y += 0.5;
        $dataNasc = (new DateTime($row['dataNascimento']))->format('d/m/Y');

        $pdf->Text(1.1, $y, 'Dependente ' . $index + 1 . ':');
        $pdf->Text(1.1, $y += 0.5, iconv('UTF-8', 'windows-1252', 'Nome: ' . $row['nome']));
        $pdf->Text(1.1, $y += 0.5, 'CPF: ' . $row['cpf']);
        $pdf->Text(1.1, $y += 0.5, 'Data de nascimento: ' . $dataNasc);
        $pdf->Text(1.1, $y += 0.5, 'Tipo de dependente: ' . iconv('UTF-8', 'windows-1252', $row['tipo_dep']));
        $y += 0.5;
    }
}

$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 11);
$pdf->Output();
