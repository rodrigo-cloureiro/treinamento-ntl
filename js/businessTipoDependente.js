function gravaTipoDependente(codigo, descricao, ativo) {
    $.ajax({
        url: 'js/sqlscopeTipoDependenteCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", codigo:codigo, descricao:descricao, ativo:ativo}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }

                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                setInterval(() => voltar(), 1500);
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function recuperaTipoDependente(id) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'recupera', id: id}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                return;
            } else {
                data = data.replace(/failed/g, '');
                let piece = data.split("#");
                let strJsonTelefone = piece[2];
                let strJsonEmail = piece[3];

                let mensagem = piece[0];
                let out = piece[1];
                piece = out.split("^");

                let codigo = +piece[0];
                let ativo = +piece[1];
                let nome = piece[2];
                let cpf = piece[3];
                let rg = piece[4];
                let genero = piece[5];
                let estadoCivil = piece[6]
                let dataNascimento = piece[7];
                let cep = piece[8];
                let logradouro = piece[9];
                let uf = piece[10];
                let bairro = piece[11];
                let cidade = piece[12];
                let numero = piece[13];
                let complemento = piece[14];

                $("#codigo").val(codigo);
                $("#nome").val(nome);
                $("#cpf").val(cpf);
                $("#rg").val(rg);
                $("#sexo").val(genero);
                $("#estadoCivil").val(estadoCivil);
                $("#dataNascimento").val(dataNascimento);
                $("#cep").val(cep);
                $("#logradouro").val(logradouro);
                $("#uf").val(uf);
                $("#bairro").val(bairro);
                $("#cidade").val(cidade);
                $("#numero").val(numero);
                $("#complemento").val(complemento);
                $("#ativo").val(ativo);
                $("#jsonTelefone").val(strJsonTelefone);
                $("#jsonEmail").val(strJsonEmail);
                calcularIdade();

                jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                fillTableTelefone();
                jsonEmailArray = JSON.parse($("#jsonEmail").val());
                fillTableEmail();
               
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirTipoDependente(id) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: 'excluir', id: id}, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                novo();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function recuperaDadosTipoDependente(callback) {
    $.ajax({
        url: 'js/sqlscopeUsuario.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosUsuario'}, //valores enviados ao script
  
        success: function (data) {
            callback(data)
        },
    })
    
    return
}
  