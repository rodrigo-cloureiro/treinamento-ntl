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

    $descricao = $utils->formatarString($_POST['descricao']);

    $sql = " SELECT codigo FROM sexo WHERE descricao = $descricao ";
    $result = $reposit->RunQuery($sql);
    $row = $result[0];

    // count($result)
    if($row && $row['codigo'] !== $codigo) {
        echo 'failed#Sexo já cadastrado';
        return;
    }

    $sql = "dbo.sexoCadastro_Atualiza
        $codigo,
        $descricao,
        $ativo";  

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

    $sql = " SELECT codigo, descricao, ativo
             FROM cadastro.dbo.tipos_dependentes WHERE (0 = 0) ";

    if ($condicaoId) {
        $sql = $sql . " AND tipos_dependentes.codigo = " . $usuarioIdPesquisa . " ";
    }

    $reposit = new reposit();
    $utils = new comum();
    $result = $reposit->RunQuery($sql);
    $row = $result[0];

    $out = "";
    if ($row) {
        $id = +$row['codigo'];
        $descricao = $row['descricao'];
        $ativo = +$row['ativo'];
    }

    $out = $id . "^" .
        $descricao . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function excluir()
{
    $reposit = new reposit();

    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $sql = "dbo.excluir_tipoDependente " . $id;

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
