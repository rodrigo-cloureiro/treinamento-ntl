<?php
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

//colocar o tratamento de permissão sempre abaixo de require_once("inc/config.ui.php");
$condicaoAcessarOK = true;
$condicaoGravarOK = true;

if ($condicaoAcessarOK == false) {
    unset($_SESSION['login']);
    header("Location:login.php");
}

$esconderBtnGravar = "";
if ($condicaoGravarOK === false) {
    $esconderBtnGravar = "none";
}

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Funcionários";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["cadastro"]["sub"]["funcionario"]["active"] = true;

include("inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Cadastro"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable centerBox">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">
                        <header>
                            <span class="widget-icon"><i class="fa fa-cog"></i></span>
                            <h2>Funcionários</h2>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <form action="javascript:gravar()" class="smart-form client-form" id="formUsuarioFiltro" method="post">
                                    <div class="panel-group smart-accordion-default" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFiltro" class="">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Filtro
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFiltro" class="panel-collapse collapse in">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-2">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value=""></option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                    <i></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Nome</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="50" name="nome" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <input id="cpf" maxlength="14" name="cpf" type="text" value="" placeholder="XXX.XXX.XXX-XX" data-mask="999.999.999-99" data-mask-placeholder="XXX.XXX.XXX-XX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado Civil</label>
                                                                <label class="select">
                                                                    <select name="estadoCivil" id="estadoCivil">
                                                                        <option value="" selected>Selecione um estado civil</option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao
                                                                                    FROM estado_civil
                                                                                    WHERE ativo = 1";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo "<option value=" . $codigo . ">" . ucfirst($descricao) . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Sexo</label>
                                                                <label class="select">
                                                                    <select name="sexo" id="sexo">
                                                                        <option value="" selected>Selecione um sexo</option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao
                                                                                    FROM sexo
                                                                                    WHERE ativo = 1";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = +$row['codigo'];
                                                                            $descricao = $row['descricao'];
                                                                            echo "<option value=" . $codigo . ">" . ucfirst($descricao) . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </label>
                                                            </section>
                                                            <!-- <section class="col col-3">
                                                                <label class="label">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section> -->
                                                            <section class="col col-2" id="sectionDataInicio">
                                                                <label class="label" id="tituloDataInicio" for="dataInicio">Data de Nascimento Início</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input style="text-align:center;" id="dataInicio" name="dataInicio" autocomplete="on" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2" id="sectionDataFim">
                                                                <label class="label" id="tituloDataFim" for="dataFim">Data de Nascimento Fim</label>
                                                                <label class="input">
                                                                    <i class="icon-append fa fa-calendar"></i>
                                                                    <input style="text-align:center;" id="dataFim" name="dataFim" autocomplete="on" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="datepicker" value="">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <footer>
                                                    <button id="btnSearch" type="button" class="btn btn-primary pull-right" title="Buscar">
                                                        <span class="fa fa-search"></span>
                                                    </button>
                                                    <?php if ($condicaoGravarOK) { ?>
                                                        <button id="btnNovo" type="button" class="btn btn-primary pull-left" title="Novo">
                                                            <span class="fa fa-file"></span>
                                                        </button>
                                                    <?php } ?>
                                                    <button id="btnPDF" type="button" class="btn btn-danger pull-left" title="Gerar PDF">
                                                        <span class="fa fa-file-pdf-o"></span>
                                                    </button>
                                                </footer>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="resultadoBusca"></div>
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
<!--script src="<?php echo ASSETS_URL; ?>/js/businessTabelaBasica.js" type="text/javascript"></script-->
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
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/locale-all.js"></script>


<script>
    $(document).ready(function() {
        $('#btnSearch').on("click", function() {
            $("#cpf").val() === "XXX.XXX.XXX-XX" ? $("#cpf").val("") : null;
            $("#dataInicio").val() === "dd/mm/aaaa" ? $("#dataInicio").val("") : null;
            $("#dataFim").val() === "dd/mm/aaaa" ? $("#dataFim").val("") : null;
            listarFiltro();
        });
        $('#btnNovo').on("click", function() {
            novo();
        });
        $("#btnPDF").on("click", function() {
            gerarPDF();
        });
    });

    function listarFiltro() {
        const ativo = $('#ativo').val();
        const nome = $('#nome').val();
        const cpf = $('#cpf').val();
        const estadoCivil = $("#estadoCivil").val();
        const sexo = $("#sexo").val();
        const dataInicio = $('#dataInicio').val();
        const dataFim = $('#dataFim').val();

        $('#resultadoBusca').load('funcionarioFiltroListagem.php?', {
            ativoFiltro: ativo,
            nomeFiltro: nome,
            cpfFiltro: cpf,
            estadoCivil: estadoCivil,
            sexo: sexo,
            dataInicio: dataInicio,
            dataFim: dataFim
        });
    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function gerarPDF() {
        const estadoCivil = $('#estadoCivil').val();
        const sexo = $('#sexo').val();
        let params = '';

        if (estadoCivil != '' && sexo != '') {
            params = 'pdfFuncionarios.php?estadoCivil=' + estadoCivil + '&sexo=' + sexo;
            window.open(params);
        }
        else if (estadoCivil != '') {
            params = 'pdfFuncionarios.php?estadoCivil=' + estadoCivil;
            window.open(params);
        } else if (sexo != "") {
            params = 'pdfFuncionarios.php?sexo=' + sexo;
            window.open(params);
        } else {
            params = 'pdfFuncionarios.php';
        }

        window.open(params);
    }

    function gerarRelatorio(e) {
        const id = e.currentTarget.value;
        window.open('pdfFuncionario.php?id=' + id);
    }
</script>