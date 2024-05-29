function gravaFuncionario(codigo, ativo, nome, cpf, rg, genero, estadoCivil, dataNascimento) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {funcao: "grava", codigo:codigo, ativo:ativo, nome:nome, cpf:cpf, rg:rg, genero:genero, estadoCivil:estadoCivil, dataNascimento:dataNascimento}, //valores enviados ao script     
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
                setInterval(() => novo(), 1500);
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function recuperaFuncionario(id) {
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
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];
                piece = out.split("^");

                var codigo = +piece[0];
                var ativo = +piece[1];
                var nome = piece[2];
                var cpf = piece[3];
                var dataNascimento = piece[4];
               
                $("#codigo").val(codigo);
                $("#nome").val(nome);
                $("#cpf").val(cpf);
                $("#dataNascimento").val(dataNascimento);
                if (ativo === 1) {
                    $('#ativo').prop('checked', true);
                } else {
                    $('#ativo').prop('checked', false);
                }
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirFuncionario(id) {
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

function recuperaDadosUsuario(callback) {
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


  function gravaNovaSenha(senha, senhaConfirma,callback) {
    $.ajax({
      url: 'js/sqlscopeUsuario.php',
      dataType: 'html', //tipo do retorno
      type: 'post', //metodo de envio
      data: {
        funcao: 'gravarNovaSenha',
        senha: senha,
        senhaConfirma: senhaConfirma,
      }, //valores enviados ao script
      success: function (data) {
        callback(data)
      },
    })
  }

  function validaCPF(cpf, callback) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'validarCPF', cpf:cpf }, //valores enviados ao script
    
        success: function (data) {
          callback(data)
        },
      })
    
  }
  