function gravaEstadoCivil(codigo, descricao, ativo) {
    $.ajax({
        url: 'js/sqlscopeEstadoCivilCadastro.php',
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

function recuperaEstadoCivil(id) {
    $.ajax({
        url: 'js/sqlscopeEstadoCivilCadastro.php', //caminho do arquivo a ser executado
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

                let mensagem = piece[0];
                let out = piece[1];
                piece = out.split("^");

                let codigo = +piece[0];
                let descricao = piece[1];
                let ativo = +piece[2];

                $("#codigo").val(codigo);
                $("#descricao").val(descricao);
                $("#ativo").val(ativo);

                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirEstadoCivil(id) {
    $.ajax({
        url: 'js/sqlscopeEstadoCivilCadastro.php', //caminho do arquivo a ser executado
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
                voltar();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                voltar();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}
  