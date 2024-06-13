<?php

use function Matrix\add;

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

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}

if ($funcao == 'gravarNovaSenha') {
    call_user_func($funcao);
}

if ($funcao == 'validarCPF') {
    call_user_func($funcao);
}

return;

function grava()
{
    $reposit = new reposit();
    $utils = new comum();

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

    if ((empty($_POST['primeiroEmprego'])) || (!isset($_POST['primeiroEmprego'])) || (is_null($_POST['primeiroEmprego']))) {
        $primeiroEmprego = 0;
    } else {
        $primeiroEmprego = (int) $_POST["primeiroEmprego"];
    }

    if ((empty($_POST['pispasep'])) || (!isset($_POST['pispasep'])) || (is_null($_POST['pispasep']))) {
        $pispasep = "'NULL'";
    } else {
        $pispasep = $utils->formatarString($_POST["pispasep"]);
    }

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
    $arrayDependente = $_POST['jsonDependente'];

    $nomeXml = "ArrayTelefone";
    $nomeTabela = "xmlTelefone";
    if ($arrayTelefone !== null && sizeof($arrayTelefone) > 0) {
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
    if ($arrayEmail !== null && sizeof($arrayEmail) > 0) {
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

    $nomeXml = "ArrayDependente";
    $nomeTabela = "xmlDependente";
    if ($arrayDependente !== null && sizeof($arrayDependente) > 0) {
        $xmlDependente = '<?xml version="1.0"?>';
        $xmlDependente = $xmlDependente . "<" . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($arrayDependente as $chave) {
            $xmlDependente = $xmlDependente . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                $xmlDependente = $xmlDependente . "<" . $campo . ">" . $valor . "</" . $campo . ">";                
            }
            $xmlDependente = $xmlDependente . "</" . $nomeTabela . ">";
        }
        $xmlDependente = $xmlDependente . "</" . $nomeXml . ">";
    } else {
        $xmlDependente = '<?xml version="1.0"?>';
        $xmlDependente = $xmlDependente . "<" . $nomeXml . '  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlDependente = $xmlDependente . "</" . $nomeXml . ">";
    }

    $xml = simplexml_load_string($xmlDependente);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de cadastro de dependente";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlDependente = "'" . $xmlDependente . "'";

    $sql = " SELECT codigo, cpf FROM funcionarios WHERE cpf = $cpf ";
    $result = $reposit->RunQuery($sql);
    $row = $result[0];

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
        $complemento,
        $primeiroEmprego,
        $pispasep,
        $xmlDependente";

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
             uf, bairro, cidade, numero, complemento,
             primeiroEmprego, pispasep
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
        $primeiroEmprego = $row['primeiroEmprego'];
        $pispasep = $row['pispasep'];
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

    $sql = " SELECT d.codigo, nome, cpf, dataNascimento, tipo, descricao FROM dependentes d JOIN tipos_dependentes t ON d.tipo = t.codigo WHERE funcionarioId = " . $usuarioIdPesquisa;
    $result = $reposit->RunQuery($sql);

    if (count($result) > 0) {
        foreach ($result as $campo) {
            $codigoDependente = +$campo['codigo'];
            $nomeDependente = $campo['nome'];
            $cpfDependente = $campo['cpf'];
            $dataNascimentoDependente = $campo['dataNascimento'];
            $tipoDependente = $campo['tipo'];
            $descricaoTipo = $campo['descricao'];
            $jsonDependente[] = array("dependenteId"=>$codigoDependente, "nomeDependente"=>$nomeDependente, "cpfDependente"=>$cpfDependente, "dataNascimentoDependente"=>$dataNascimentoDependente, "tipoDependente"=>$tipoDependente, "descricaoTipo"=>$descricaoTipo);
        }
    }
    $jsonDependenteArray = json_encode($jsonDependente);

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
        $complemento . "^" .
        $primeiroEmprego . "^" .
        $pispasep;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out . "#" . $jsonTelefoneArray . "#" . $jsonEmailArray . "#" . $jsonDependenteArray;
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

function validaUsuario($login)
{
    $sql = "SELECT codigo,[login],ativo FROM Ntl.usuario
    WHERE [login] LIKE $login and ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        return true;
    } else {
        return false;
    }
}

function recuperarDadosUsuario()
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


function gravarNovaSenha()
{
    $reposit = new reposit();
    $senhaConfirma = $_POST["senhaConfirma"];
    $senha = $_POST["senha"];

    if ((empty($_POST['senhaConfirma'])) || (!isset($_POST['senhaConfirma'])) || (is_null($_POST['senhaConfirma']))) {
        $senhaConfirma = null;
    }
    if ((empty($_POST['senha'])) || (!isset($_POST['senha'])) || (is_null($_POST['senha']))) {
        $senha = null;
    }

    if ((!is_null($senhaConfirma)) or (!is_null($senha))) {
        $comum = new comum();
        $validouSenha = 1;
        if (!is_null($senha)) {
            $validouSenha = $comum->validaSenha($senha);
        }
        if ($validouSenha === 0) {
            if ($senhaConfirma !== $senha) {
                $mensagem = "A confirmação da senha deve ser igual a senha.";
                echo "failed#" . $mensagem . ' ';
                return;
            } else {
                $comum = new comum();
                $senhaCript = $comum->criptografia($senha);
                $senha = "'" . $senhaCript . "'";
            }
        } else {
            switch ($validouSenha) {
                case 1:
                    $mensagem = "Senha não pode conter espaços.";
                    break;
                case 2:
                    $mensagem = "Senha deve possuir no mínimo 7 caracter.";
                    break;
                case 3:
                    $mensagem = "Senha ultrapassou de 15 caracteres.";
                    break;
                case 4:
                    $mensagem = "Senha deve possuir no mínimo um caractér númerico.";
                    break;
                case 5:
                    $mensagem = "Senha deve possuir no mínimo um caractér alfabético.";
                    break;
                case 6:
                    $mensagem = "Senha deve possuir no mínimo um caracter especial.\nSão válidos : ! # $ & * - + ? . ; , : ] [ ( )";
                    break;
                case 7:
                    $mensagem = "Senha não pode ter caracteres acentuados.";
                    break;
            }
            echo "failed#" . $mensagem . ' ';
            return;
        }
    }

    session_start();
    $login = "'" .  $_SESSION['login'] . "'";
    $usuario =  $login;

    $id = $_SESSION['codigo'];
    $funcionario = $_SESSION['funcionario'];
    if (!$funcionario) {
        $funcionario = 'NULL';
    }
    $ativo = 1;
    $tipoUsuario = 'C';
    $restaurarSenha = 0;

    $sql = "Ntl.usuario_Atualiza " . $id . "," . $ativo . "," . $login . "," . $senha . "," . $tipoUsuario . "," . $usuario . "," . $funcionario . "," . $restaurarSenha . " ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';

    if ($result < 1) {
        $ret = 'failed#';
    }

    echo $ret;
    return;
}

function validarCPF() {

    if ((empty($_POST['cpf'])) || (!isset($_POST['cpf'])) || (is_null($_POST['cpf']))) {
        echo "failed#Parâmetro não enviado";
        return;
    } else {
        $cpf = $_POST["cpf"];
    }

    $utils = new comum();

    $result = $utils->validaCPF($cpf);

    echo $result ? "success" : "failed#CPF Inválido!";
    return;
}

// function verificarCadastroCPF() {
//     $reposit = new reposit();
//     $cpfs = [];

//     if ((empty($_POST['cpf'])) || (!isset($_POST['cpf'])) || (is_null($_POST['cpf']))) {
//         echo "failed#Parâmetro não enviado";
//         return;
//     } else {
//         $cpf = $_POST["cpf"];
//     }
    
//     $sql = " SELECT cpf FROM funcionarios ";
//     $result = $reposit->RunQuery($sql);
//     array_push($cpfs, ...$result);

//     $sql = " SELECT cpf FROM dependentes ";
//     $result = $reposit->RunQuery($sql);
//     array_push($cpfs, ...$result);

//     $exists = in_array($cpf, $cpfs);
// }
