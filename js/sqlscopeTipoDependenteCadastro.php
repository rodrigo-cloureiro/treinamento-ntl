<?php

include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaDadosTipoDependente') {
    call_user_func($funcao);
}

return;

function grava()
{
    if ((empty($_POST['codigo'])) || (!isset($_POST['codigo'])) || (is_null($_POST['codigo']))) {
        $codigo = 0;
    } else {
        $codigo = (int) $_POST["codigo"];
    }

    if ((empty($_POST['ativo'])) || (!isset($_POST['ativo'])) || (is_null($_POST['ativo']))) {
        $ativo = 0;
    } else {
        $ativo = (int) $_POST["ativo"];
    }

    $reposit = new reposit();
    $utils = new comum();

    $nome = $utils->formatarString($_POST['nome']);
    $cpf = $utils->formatarString($_POST['cpf']);
    $rg = $utils->formatarString($_POST['rg']);
    $genero = $utils->formatarString($_POST['genero']);
    $estadoCivil = $utils->formatarString($_POST['estadoCivil']);
    $dataNascimento = $utils->formatarDataSql($_POST['dataNascimento']);
    $arrayTelefone = $_POST['jsonTelefone'];
    $arrayEmail = $_POST['jsonEmail'];
    $cep = $utils->formatarString($_POST['cep']);
    $logradouro = $utils->formatarString($_POST['logradouro']);
    $uf = $utils->formatarString($_POST['uf']);
    $bairro = $utils->formatarString($_POST['bairro']);
    $cidade = $utils->formatarString($_POST['cidade']);
    $numero = $utils->formatarString($_POST['numero']);
    $complemento = $utils->formatarString($_POST['complemento']);

    $nomeXml = "ArrayTelefone";
    $nomeTabela = "xmlTelefone";
    if (sizeof($arrayTelefone) > 0) {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayTelefone as $chave) {
            $xmlTelefone = $xmlTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                $xmlTelefone = $xmlTelefone . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlTelefone = $xmlTelefone . "</" . $nomeTabela . ">";
        }
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    } else {
        $xmlTelefone = '<?xml version="1.0"?>';
        $xmlTelefone = $xmlTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlTelefone = $xmlTelefone . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlTelefone);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de cadastro de telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlTelefone = "'" . $xmlTelefone . "'";

    $nomeXml = "ArrayEmail";
    $nomeTabela = "xmlEmail";
    if (sizeof($arrayEmail) > 0) {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayEmail as $chave) {
            $xmlEmail = $xmlEmail . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                $xmlEmail = $xmlEmail . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlEmail = $xmlEmail . "</" . $nomeTabela . ">";
        }
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    } else {
        $xmlEmail = '<?xml version="1.0"?>';
        $xmlEmail = $xmlEmail . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlEmail = $xmlEmail . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlEmail);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de cadastro de email";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlEmail = "'" . $xmlEmail . "'";

    $sql = " SELECT codigo, cpf FROM funcionarios WHERE cpf = $cpf ";
    $result = $reposit->RunQuery($sql);
    $row = $result[0];

    // if(!$utils->validaCPF($cpf)) {
    //     echo 'failed#CPF inválido';
    //     return;
    // }

    // count($result)
    if($row && $row['codigo'] !== $codigo) {
        echo 'failed#CPF já cadastrado';
        return;
    }

    $sql = " SELECT codigo, rg FROM funcionarios WHERE rg = $rg ";
    $result = $reposit->RunQuery($sql);
    $row = $result[0];

    if($row && $row['codigo'] !== $codigo) {
        echo 'failed#RG já cadastrado';
        return;
    }

    $sql = "dbo.funcionarioCadastro_Atualiza
        $codigo,
        $ativo,
        $nome,
        $cpf,
        $rg,
        $genero,
        $estadoCivil,
        $dataNascimento,
        $xmlTelefone,
        $xmlEmail,
        $cep,
        $logradouro,
        $uf,
        $bairro,
        $cidade,
        $numero,
        $complemento";  

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));

    if (($condicaoId === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ($condicaoId) {
        $usuarioIdPesquisa = $_POST["id"];
    }

    $sql = " SELECT codigo, ativo, nome, cpf, rg, genero,
             estadoCivil, dataNascimento, cep, logradouro,
             uf, bairro, cidade, numero, complemento
             FROM cadastro.dbo.funcionarios WHERE (0 = 0) ";

    if ($condicaoId) {
        $sql = $sql . " AND funcionarios.codigo = " . $usuarioIdPesquisa . " ";
    }

    $reposit = new reposit();
    $utils = new comum();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $rg = $row['rg'];
        $genero = $row['genero'];
        $estadoCivil = $row['estadoCivil'];
        $dataNascimento = $utils->validaDataInversa($row['dataNascimento']);
        $cep = $row['cep'];
        $logradouro = $row['logradouro'];
        $uf = $row['uf'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $numero = $row['numero'];
        $complemento = $row['complemento'];
    }

    $sql = " SELECT codigo, sequencial, telefone, principal, whatsapp FROM telefones WHERE funcionarioId = " . $usuarioIdPesquisa;
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        foreach ($result as $campo) {
            $codigo = +$campo['codigo'];
            $sequencial = +$campo['sequencial'];
            $telefone = $campo['telefone'];
            $principal = +$campo['principal'];
            $whatsapp = +$campo['whatsapp'];
            $jsonTelefone[] = array("telefoneId"=>$codigo, "sequencialTel"=>$sequencial, "telefone"=>$telefone, "telPrincipal"=>$principal, "whatsapp"=>$whatsapp);
        }
    }
    $jsonTelefoneArray = json_encode($jsonTelefone);
    
    $sql = " SELECT codigo, sequencial, email, principal FROM emails WHERE codigo_func = " . $usuarioIdPesquisa;
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        foreach ($result as $campo) {
            $codigo = +$campo['codigo'];
            $sequencial = +$campo['sequencial'];
            $email = $campo['email'];
            $principal = +$campo['principal'];
            $jsonEmail[] = array("emailId"=>$codigo, "sequencialEmail"=>$sequencial, "email"=>$email, "emailPrincipal"=>$principal);
        }
    }
    $jsonEmailArray = json_encode($jsonEmail);

    $out =   $id . "^" .
        $ativo . "^" .
        $nome . "^" .
        $cpf . "^" .
        $rg . "^" .
        $genero . "^" .
        $estadoCivil . "^" .
        $dataNascimento . "^" .
        $cep . "^" .
        $logradouro . "^" .
        $uf . "^" .
        $bairro . "^" .
        $cidade . "^" .
        $numero . "^" .
        $complemento;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $jsonTelefoneArray . "#" . $jsonEmailArray;
    return;
}

function excluir()
{

    $reposit = new reposit();
    // $possuiPermissao = $reposit->PossuiPermissao("USUARIO_ACESSAR|USUARIO_EXCLUIR");

    // if ($possuiPermissao === 0) {
    //     $mensagem = "O usuário não tem permissão para excluir!";
    //     echo "failed#" . $mensagem . ' ';
    //     return;
    // }

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    // session_start();
    // $usuario = $_SESSION['login'];
    // $usuario = "'" . $usuario . "'";

    $sql = "excluir_funcionario " . $id;

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}

function recuperaDadosTipoDependente()
{

    session_start();
    $codigoLogin = $_SESSION['codigo'];

    $sql = "SELECT codigo, login, ativo, restaurarSenha
    FROM Ntl.usuario
    WHERE (0=0) AND
    codigo = " . $codigoLogin;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int)$row['codigo'];
        $restaurarSenha = $row['restaurarSenha'];
    }

    $out = $codigo . "^" .
        $restaurarSenha;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}
