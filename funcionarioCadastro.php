<?php

include "girComum.php";

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = true;
$condicaoGravarOK = true;
$condicaoExcluirOK = true;

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

$esconderBtnExcluir = "";
if ($condicaoExcluirOK === false) {
    $esconderBtnExcluir = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Usuário";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["configuracao"]["sub"]["usuarios"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Configurações"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false" style="">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Usuário</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuario" method="post">    
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCadastro" class="" id="accordionCadastro">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Cadastro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseCadastro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <!-- <div class="row">
                                                            <section class="col col-1 hidden">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                    <i></i>
                                                                </label>
                                                            </section>                                               
                                                        </div> -->
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-3 hidden">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                    <i></i>
                                                                </label>
                                                            </section>                       
                                                            <section class="col col-3">
                                                                <label class="label">Nome</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="255" name="nome" class="required" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" maxlength="20" name="cpf" type="text" class="required" value="" placeholder="XXX.XXX.XXX-XX" data-mask="999.999.999-99" data-mask-placeholder="XXX.XXX.XXX-XX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <input type="text" id="rg" name="rg" class="required" value="" placeholder="XX.XXX.XXX-X" data-mask="99.999.999-9" data-mask-placeholder="XX.XXX.XXX-X">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Sexo</label>
                                                                <label class="select">
                                                                    <select name="sexo" id="sexo" class="required">
                                                                        <option value="" disabled selected>Selecione um gênero</option>
                                                                        <option value="1">Mulher cisgênero</option>
                                                                        <option value="2">Mulher transgênero</option>
                                                                        <option value="3">Mulher transexual</option>
                                                                        <option value="4">Homem cisgênero</option>
                                                                        <option value="5">Homem transgênero</option>
                                                                        <option value="6">Homem transexual</option>
                                                                        <option value="7">Gênero não-binário</option>
                                                                        <option value="8">Gênero-fluido</option>
                                                                        <option value="9">Gênero neutro</option>
                                                                        <option value="10">Agênero</option>
                                                                        <option value="11">Bigênero</option>
                                                                        <option value="12">Poligênero</option>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" autocomplete="on" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="required datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Idade</label>
                                                                <label class="input">
                                                                    <input type="text" id="idade" name="idade" class="readonly" readonly placeholder="0" value="">
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-4 col-auto">
                                                                <label class="label " for="funcionario">Funcionário</label>
                                                                <label class="select">
                                                                    <select id="funcionario" name="funcionario">
                                                                        <option></option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, nome 
                                                                        FROM Ntl.funcionario 
                                                                        WHERE ativo = 1 AND dataDemissaoFuncionario IS NULL order by nome";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach($result as $row) {
                                                                            $id = $row['codigo'];
                                                                            $descricao = $row['nome'];
                                                                            echo '<option value=' . $id . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select><i></i>
                                                                </label>
                                                            </section> -->
                                                            <!-- <section class="col col-2 col-auto">
                                                                <label class="label">Restaurar senha</label>
                                                                <label class="select">
                                                                    <select id="restaurarSenha" name="restaurarSenha">
                                                                        <option value="1" >Sim</option> 
                                                                        <option value="0">Não</option> 
                                                                    </select><i></i> 
                                                                </label> 
                                                            </section>  -->
                                                        </div>
                                                    </fieldset>
                                                </div>                                                        
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash" ></span>
                                        </button>
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" 
                                             tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" 
                                             style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
                                            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                                                <span id="ui-id-2" class="ui-dialog-title">
                                                </span>
                                            </div>
                                            <div id="dlgSimpleExcluir" class="ui-dialog-content ui-widget-content" style="width: auto; min-height: 0px; max-height: none; height: auto;">
                                                <p>CONFIRMA A EXCLUSÃO ? </p>
                                            </div>
                                            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                                                <div class="ui-dialog-buttonset">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submited" id="btnGravar" class="btn btn-success" aria-hidden="true" title="Gravar" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-floppy-o" ></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o" ></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward " ></span>
                                        </button>
                                    </footer>
                                </form>                                            
                            </div>
                        </div>                                
                    </div>                                
                </article>
            </div>
        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<script src="<?php echo ASSETS_URL; ?>/js/businessFuncionario.js" type="text/javascript"></script> 

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/moment/moment.min.js"></script>
<!--<script src="/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>-->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/fullcalendar.js"></script>
<!--<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>-->


<!-- Form to json -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/form2js.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/form-to-json/jquery.toObject.js"></script>


<script language="JavaScript" type="text/javascript">
    $(document).ready(function () {
        // $("#cpf").mask("999.999.999-99");
        // $("#dataNascimento").mask("99/99/9999");

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dlgSimpleExcluir').dialog({
            autoOpen: false,
            width: 400,
            resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4><i class='fa fa-warning'></i> Atenção</h4></div>",
            buttons: [{
                    html: "Excluir registro",
                    "class": "btn btn-success",
                    click: function () {
                        $(this).dialog("close");
                        excluir();
                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
        });

        $("#btnExcluir").on("click", function () {
            var id = +$("#codigo").val();

            if (id === 0) {
                smartAlert("Atenção", "Selecione um registro para excluir !", "error");
                $("#nome").focus();
                return;
            }

            if (id !== 0) {
                $('#dlgSimpleExcluir').dialog('open');
            }
        });

        $("#btnNovo").on("click", function () {
            novo();
        });

        $("#btnVoltar").on("click", function () {
            voltar();
        });

        $("#dataNascimento").on("change", function() {
            calcularIdade();
        });

        $("#cpf").on("focusout", function(campo) {
            validaCPF(campo.currentTarget.value, results => {
                if(results.indexOf('success') < 0) {
                    let piece = results.split('#');
                    let mensagem = piece[1];
                    if (mensagem !== "") {
                        smartAlert("Atenção", mensagem, "error");
                    } else {
                        smartAlert("Atenção", "CPF Inválido", "error");
                    }

                    return '';
                }
            });
        });

        carregaPagina();
    });

    function carregaPagina() {
        var urlx = window.document.URL.toString();
        var params = urlx.split("?");
        if (params.length === 2) {
            var id = params[1];
            var idx = id.split("=");
            var idd = idx[1];
            if (idd !== "") {
                recuperaFuncionario(idd);
            }
        }
        $("#nome").focus();

    }
    
    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'usuarioFiltro.php');
    }

    function excluir() {
        var id = +$("#codigo").val();

        if (id === 0) {
            smartAlert("Atenção", "Selecione um registro para excluir!", "error");
            return;
        }

        excluirFuncionario(id);
    }

    function gravar() {
        var codigo = +($("#codigo").val());
        var ativo = $("#ativo").val();
        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var dataNascimento = $("#dataNascimento").val();
        
        if(nome == "") {
            smartAlert("Atenção", "O nome precisa ser preenchido", "error");
            $("#nome").focus();
            return;
        }
        
        if(cpf == "") {
            smartAlert("Atenção", "O CPF precisa ser preenchido", "error");
            $("#cpf").focus();
            return;
        }

        if(dataNascimento == "") {
            smartAlert("Atenção", "A data de nascimento precisa ser preenchido", "error");
            $("#dataNascimento").focus();
            return;
        } else {
            if(!dataValida(dataNascimento)) {
                smartAlert("Atenção", "A data de nascimento não é válida", "error");
                return;
            }
        }

        gravaFuncionario(codigo, ativo, nome, cpf, dataNascimento);
    }

    function calcularIdade() {
        var dataNascimento = $("#dataNascimento").val();
        if (!dataValida(dataNascimento)) {
            return false;
        }
        dataNascimento = dataNascimento.split('/');
        var dataAtual = new Date().toLocaleDateString('pt-BR').split('/');
        var idade = dataAtual[2] - dataNascimento[2];
        var mes = dataAtual[1] - dataNascimento[1];

        if(mes < 0 || mes === 0 && dataAtual[0] < dataNascimento[0]) {
            idade -= 1;
        }

        $("#idade").val(idade);
    }

    function dataValida(data) {
        var dataAtual = new Date();
        var nascimentoSplit = data.split('/');
        var dataNascimento = new Date(nascimentoSplit[2], nascimentoSplit[1]-1, nascimentoSplit[0]);
        var dias30 = [4, 6, 9, 11];
        var dias31 = [1, 3, 5, 7, 8, 10, 12];
        
        if(dataAtual < dataNascimento) {
            return false;
        }

        // nascimentoSplit[2] -> ano
        // nascimentoSplit[1]-1 -> mês
        // nascimentoSplit[0] -> dia
        if (nascimentoSplit[1] < 0 || nascimentoSplit[1] > 12 || nascimentoSplit[0] < 1 || nascimentoSplit[1] > 31) {
            return false;
        }

        if(dias30.includes(nascimentoSplit[1]) && nascimentoSplit[0] > 30) {
            return false;
        }

        if(dias31.includes(nascimentoSplit[1]) && nascimentoSplit[0] > 31) {
            return false;
        }

        if(!ehBissexto(nascimentoSplit[2]) && (nascimentoSplit[1] == 2 && nascimentoSplit[0] > 28)) {
            return false;
        }

        return true;
    }

    function ehBissexto(ano) {
        if((ano % 4 == 0 && ano % 100 != 0) || ano % 400 == 0) {
            return true;
        }

        return false;
    }
</script>

