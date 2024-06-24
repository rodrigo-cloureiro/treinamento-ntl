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
                                <form class="smart-form client-form" id="formUsuario">
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
                                                        <div class="row">
                                                        </div>
                                                        <div class="row">
                                                            <section class="col col-2 hidden">
                                                                <label class="label">Código</label>
                                                                <label class="input">
                                                                    <input id="codigo" name="codigo" type="text" class="readonly" readonly>
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Ativo</label>
                                                                <label class="select">
                                                                    <select id="ativo" name="ativo">
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                    <i style="box-shadow: none;"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-4">
                                                                <label class="label">Nome</label>
                                                                <label class="input"><i class="icon-prepend fa fa-user"></i>
                                                                    <input id="nome" maxlength="255" name="nome" class="required" type="text" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">CPF</label>
                                                                <label class="input">
                                                                    <i class="icon-prepend fa fa-id-card-o"></i>
                                                                    <input id="cpf" maxlength="20" name="cpf" type="text" class="required" value="" placeholder="XXX.XXX.XXX-XX" data-mask="999.999.999-99" data-mask-placeholder="XXX.XXX.XXX-XX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">RG</label>
                                                                <label class="input">
                                                                    <i class="icon-prepend fa fa-id-card-o"></i>
                                                                    <input type="text" id="rg" name="rg" class="required" value="" placeholder="XX.XXX.XXX-X" data-mask="99.999.999-9" data-mask-placeholder="XX.XXX.XXX-X">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Sexo</label>
                                                                <label class="select">
                                                                    <select name="sexo" id="sexo" class="required">
                                                                        <option value="" disabled selected>Selecione um sexo</option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao
                                                                                FROM sexo
                                                                                WHERE ativo = 1";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ucfirst($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <i style="box-shadow: none;"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Estado Civil</label>
                                                                <label class="select">
                                                                    <select name="estadoCivil" id="estadoCivil" class="required">
                                                                        <option value="" disabled selected>Selecione um estado civil</option>
                                                                        <?php
                                                                        $reposit = new reposit();
                                                                        $sql = "SELECT codigo, descricao
                                                                                FROM cadastro.dbo.estado_civil
                                                                                WHERE ativo = 1";
                                                                        $result = $reposit->RunQuery($sql);
                                                                        foreach ($result as $row) {
                                                                            $codigo = $row['codigo'];
                                                                            $descricao = ucfirst($row['descricao']);
                                                                            echo '<option value=' . $codigo . '>' . $descricao . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <i style="box-shadow: none;"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Data de Nascimento</label>
                                                                <label class="input">
                                                                    <input id="dataNascimento" name="dataNascimento" autocomplete="on" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa" type="text" class="required datepicker" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Idade</label>
                                                                <label class="input">
                                                                    <input type="text" id="idade" name="idade" class="readonly" readonly placeholder="0" value="">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Primeiro Emprego</label>
                                                                <label class="select">
                                                                    <select name="primeiroEmprego" id="primeiroEmprego" class="required">
                                                                        <option value="" disabled selected>Selecione uma opção</option>
                                                                        <option value="1">Sim</option>
                                                                        <option value="0">Não</option>
                                                                    </select>
                                                                    <i style="box-shadow: none;"></i>
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">PIS-PASEP</label>
                                                                <label class="input">
                                                                    <input type="text" id="pispasep" class="required" name="pispasep" value="" data-mask="999.99999.99-9" data-mask-placeholder="XXX.XXXXX.XX-X">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContato" class="" id="accordionContato">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Contato
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseContato" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset class="col col-6">
                                                        <input class="col col-12" id="jsonTelefone" name="jsonTelefone" type="hidden" value="[]">
                                                        <div id="formTelefone" class="col-sm-12">
                                                            <input type="hidden" id="telefoneId" name="telefoneId">
                                                            <input type="hidden" id="sequencialTel" name="sequencialTel">
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label">Telefone</label>
                                                                    <label class="input">
                                                                        <i class="icon-prepend fa fa-phone"></i>
                                                                        <input id="telefone" maxlength="50" name="telefone" class="" type="text" value="" placeholder="(XX) XXXXX-XXXX">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelAtivo" class="checkbox ">
                                                                        <input checked="checked" id="telPrincipal" name="telPrincipal" type="checkbox" value="true"><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelAtivo" class="checkbox ">
                                                                        <input checked="checked" id="whatsapp" name="whatsapp" type="checkbox" value="true"><i></i>
                                                                        WhatsApp
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddTelefone" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverTelefone" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <div class="table-responsive" style="min-height: 115px;width: 95%;border: 1px solid #ddd;margin-bottom: 13px;overflow-x: hidden;">
                                                                        <table id="tableTelefone" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th></th>
                                                                                    <th class="text-left" style="min-width: 500%">Telefone</th>
                                                                                    <th class="text-left" style="min-width: 500%">Principal</th>
                                                                                    <th class="text-left" style="min-width: 500%">WhatsApp</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody></tbody>
                                                                        </table>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="col col-6">
                                                        <input type="hidden" id="jsonEmail" name="jsonEmail" value="[]">
                                                        <div id="formEmail" class="col-sm-12">
                                                            <input type="hidden" id="emailId" name="emailId">
                                                            <input type="hidden" id="sequencialEmail" name="sequencialEmail">
                                                            <div class="row">
                                                                <section class="col col-6">
                                                                    <label class="label">Email</label>
                                                                    <label class="input">
                                                                        <i class="icon-prepend fa fa-envelope"></i>
                                                                        <input id="email" maxlength="70" name="email" class="" type="text" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <label id="labelAtivo" class="checkbox">
                                                                        <input checked="checked" id="emailPrincipal" name="emailPrincipal" type="checkbox" value="true"><i></i>
                                                                        Principal
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddEmail" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverEmail" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <div class="table-responsive" style="min-height: 115px;width: 95%;border: 1px solid #ddd;margin-bottom: 13px;overflow-x: hidden;">
                                                                        <table id="tableEmail" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th></th>
                                                                                    <th class="text-left" style="min-width: 500%">Email</th>
                                                                                    <th class="text-left" style="min-width: 500%">Principal</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody></tbody>
                                                                        </table>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="#collapseEndereco" data-toggle="collapse" data-parent="#accordion" id="accordionEndereco">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Endereço
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseEndereco" class="panel-collapse collapse">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <div class="row">
                                                            <section class="col col-1">
                                                                <label class="label">CEP</label>
                                                                <label class="input">
                                                                    <input id="cep" name="cep" type="text" value="" class="required" placeholder="XXXXX-XXX" data-mask="99999-999" data-mask-placeholder="XXXXX-XXX">
                                                                </label>
                                                            </section>
                                                            <section class="col col-3">
                                                                <label class="label">Logradouro</label>
                                                                <label class="input">
                                                                    <input id="logradouro" name="logradouro" type="text" value="" class="required" placeholder="Logradouro">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">UF</label>
                                                                <label class="input">
                                                                    <input type="text" value="" id="uf" name="uf" class="required" placeholder="UF">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Bairro</label>
                                                                <label class="input">
                                                                    <input type="text" value="" id="bairro" name="bairro" class="required" placeholder="Bairro">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Cidade</label>
                                                                <label class="input">
                                                                    <input type="text" value="" id="cidade" name="cidade" class="required" placeholder="Cidade">
                                                                </label>
                                                            </section>
                                                            <section class="col col-1">
                                                                <label class="label">Número</label>
                                                                <label class="input">
                                                                    <input type="text" value="" id="numero" name="numero" class="required" placeholder="Número">
                                                                </label>
                                                            </section>
                                                            <section class="col col-2">
                                                                <label class="label">Complemento</label>
                                                                <label class="input">
                                                                    <input type="text" value="" id="complemento" name="complemento" placeholder="Complemento">
                                                                </label>
                                                            </section>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="#collapseDependente" data-toggle="collapse" data-parent="#accordion" id="accordionDependente">
                                                        <i class="fa fa-lg fa-angle-down pull-right"></i>
                                                        <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                        Dependente
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse" id="collapseDependente">
                                                <div class="panel-body no-padding">
                                                    <fieldset>
                                                        <input class="col col-12" id="jsonDependentes" name="jsonDependentes" type="hidden" value="[]" />
                                                        <div id="formDependente" class="col-sm-12">
                                                            <input type="hidden" id="dependenteId" name="dependenteId">
                                                            <input type="hidden" id="sequencialDep" name="sequencialDep">
                                                            <div class="row">
                                                                <section class="col col-4">
                                                                    <label class="label">Nome</label>
                                                                    <label class="input">
                                                                        <i class="icon-prepend fa fa-user"></i>
                                                                        <input type="text" id="nomeDependente" name="nomeDependente" value="">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">CPF</label>
                                                                    <label class="input">
                                                                        <i class="icon-prepend fa fa-id-card-o"></i>
                                                                        <input type="text" id="cpfDependente" name="cpfDependente" value="" placeholder="XXX.XXX.XXX-XX" data-mask="999.999.999-99" data-mask-placeholder="XXX.XXX.XXX-XX">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-2">
                                                                    <label class="label">Data de Nascimento</label>
                                                                    <label class="input">
                                                                        <input type="text" class="datepicker" id="dataNascimentoDependente" name="dataNascimentoDependente" value="" data-mask="99/99/9999" data-mask-placeholder="dd/mm/aaaa" data-dateformat="dd/mm/yy" placeholder="dd/mm/aaaa">
                                                                    </label>
                                                                </section>
                                                                <secion class="col col-2">
                                                                    <label class="label">Tipo de Dependente</label>
                                                                    <label class="select">
                                                                        <select name="tipoDependente" id="tipoDependente">
                                                                            <option value="" disabled selected>Selecione uma opção</option>
                                                                            <?php
                                                                            $reposit = new reposit();
                                                                            $sql = "SELECT codigo, descricao
                                                                                FROM tipos_dependentes
                                                                                WHERE ativo = 1";
                                                                            $result = $reposit->RunQuery($sql);
                                                                            foreach ($result as $row) {
                                                                                $codigo = +$row['codigo'];
                                                                                $descricao = $row['descricao'];
                                                                                echo "<option value=" . $codigo . ">" . ucfirst($descricao) . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <i style="box-shadow: none;"></i>
                                                                    </label>
                                                                </secion>
                                                                <section class="col col-2">
                                                                    <label class="label">&nbsp;</label>
                                                                    <button id="btnAddDependente" type="button" class="btn btn-primary">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                    <button id="btnRemoverDependente" type="button" class="btn btn-danger">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-12">
                                                                    <div class="table-responsive" style="min-height: 115px;width: 100%;border: 1px solid #ddd;margin-bottom: 13px;overflow-x: hidden;">
                                                                        <table id="tableDependentes" class="table table-bordered table-striped table-condensed table-hover dataTable">
                                                                            <thead>
                                                                                <tr role="row">
                                                                                    <th></th>
                                                                                    <th class="text-left" style="min-width: 500%">Nome</th>
                                                                                    <th class="text-left" style="min-width: 500%">CPF</th>
                                                                                    <th class="text-left" style="min-width: 500%">Data de Nascimento</th>
                                                                                    <th class="text-left" style="min-width: 500%">Tipo de Dependente</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody></tbody>
                                                                        </table>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer>
                                        <button type="button" id="btnExcluir" class="btn btn-danger hidden" aria-hidden="true" title="Excluir" style="display:<?php echo $esconderBtnExcluir ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="dlgSimpleExcluir" aria-labelledby="ui-id-1" style="height: auto; width: 600px; top: 220px; left: 262px; display: none;">
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
                                            <span class="fa fa-floppy-o"></span>
                                        </button>
                                        <button type="button" id="btnNovo" class="btn btn-primary hidden" aria-hidden="true" title="Novo" style="display:<?php echo $esconderBtnGravar ?>">
                                            <span class="fa fa-file-o"></span>
                                        </button>
                                        <button type="button" id="btnVoltar" class="btn btn-default" aria-hidden="true" title="Voltar">
                                            <span class="fa fa-backward "></span>
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
    $(document).ready(function() {
        // $("#cpf").mask("999.999.999-99");
        // $("#dataNascimento").mask("99/99/9999");
        jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
        jsonEmailArray = JSON.parse($("#jsonEmail").val());
        jsonDependenteArray = JSON.parse($("#jsonDependentes").val());

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
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
                click: function() {
                    $(this).dialog("close");
                    excluir();
                }
            }, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancelar",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog("close");
                }
            }]
        });

        $("#btnGravar").on("click", function(e) {
            e.preventDefault();
            gravar();
        });

        $("#btnExcluir").on("click", function() {
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

        $("#btnNovo").on("click", function() {
            novo();
        });

        $("#btnVoltar").on("click", function() {
            voltar();
        });

        $("#dataNascimento").on("focusout", function() {
            $("#idade").val(0);
            if (!dataValida($("#dataNascimento").val())) {
                smartAlert("Atenção", "A data de nascimento não é válida!", "error");
                $("#dataNascimento").val('').focus();
            }

            if ($("#dataNascimento").val() !== 'dd/mm/aaaa') {
                calcularIdade();
            }
        });

        $("#nome").on("keypress", function(e) {
            if (e.keyCode >= 48 && e.keyCode <= 57) {
                e.preventDefault();
            }
        });

        $("#nome").on("focusout", function() {
            $("#nome").val($.trim($("#nome").val()));
        });

        $("#cpf").on("focusout", function(campo) {
            const mask = $("#cpf").mask();
            const codigo = $("#codigo").val();
            if (mask.length === 11) {
                validaCPF(codigo, campo.currentTarget.value, results => {
                    if (results.indexOf('success') < 0) {
                        let piece = results.split('#');
                        let mensagem = piece[1];
                        if (mensagem !== "") {
                            smartAlert("Atenção", mensagem, "error");
                        } else {
                            smartAlert("Atenção", "CPF Inválido", "error");
                        }
                        $("#cpf").val('').focus();
                        return '';
                    }
                });
            }
        });

        $("#rg").on("focusout", function(campo) {
            if (!validaRG(campo.currentTarget.value)) {
                smartAlert("Atenção", "RG inválido.", "error");
                $("#rg").val('').focus();
            }
        });

        $("#btnAddTelefone").on("click", function() {
            addTelefone();
        });

        $("#telefone").mask("(99) 99999-9999", {
            autoclear: 0
        });

        // $("#telPrincipal").prop("checked", false);
        $("#whatsapp").prop("checked", false);
        // $("#emailPrincipal").prop("checked", false);

        // $("#cpf").off('blur focus keydown');
        // $("#rg").off('blur focus keydown');

        $("#btnRemoverTelefone").on("click", function() {
            excluirContato();
        });

        $("#btnAddEmail").on("click", function() {
            addEmail();
        });

        $("#btnRemoverEmail").on("click", function() {
            excluirEmail();
        });

        $("#cep")
            .off('blur focus')
            .on("focusout", function() {
                const cep = $("#cep").val();
                if (cep !== "" && cep !== $("#cep").attr('placeholder')) {
                    preencheEndereco(cep);
                } else {
                    clearEndereco();
                }
            });

        $("#primeiroEmprego").on("change", function() {
            const primeiroEmprego = +$("#primeiroEmprego").val();

            if (primeiroEmprego != 0) {
                $("#pispasep")
                    .val("")
                    .removeClass('required')
                    .attr('readonly', true);
            } else {
                $("#pispasep")
                    .addClass('required')
                    .removeAttr('readonly');
            }
        });

        $("#cpfDependente").on("focusout", function(campo) {
            const mask = $("#cpfDependente").mask();
            const codigo = $("#cpf").val();
            if (mask.length === 11) {
                validaCPF(codigo, campo.currentTarget.value, results => {
                    if (results.indexOf('success') < 0) {
                        let piece = results.split('#');
                        let mensagem = piece[1];
                        if (mensagem !== "") {
                            smartAlert("Atenção", mensagem, "error");
                        } else {
                            smartAlert("Atenção", "CPF Inválido", "error");
                        }
                        $("#cpfDependente").focus();
                        return '';
                    }
                });
            }
        });

        $("#dataNascimentoDependente").on("focusout", function() {
            if (!dataValida($("#dataNascimentoDependente").val())) {
                smartAlert("Atenção", "A data de nascimento não é válida!", "error");
                $("#dataNascimentoDependente").focus();
            }
        });

        $("#nomeDependente").on("focusout", function() {
            $("#nomeDependente").val($.trim($("#nomeDependente").val()));
        });

        $("#nomeDependente").on("keypress", function(e) {
            if (e.keyCode >= 48 && e.keyCode <= 57) {
                e.preventDefault();
            }
        });

        $("#btnAddDependente").on("click", function() {
            addDependente();
        });

        $("#btnRemoverDependente").on("click", function() {
            excluirDependente();
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
            $("#btnExcluir").removeClass("hidden");
            $("#btnNovo").removeClass("hidden");
        }
        $("#nome").focus();

    }

    function novo() {
        $(location).attr('href', 'funcionarioCadastro.php');
    }

    function voltar() {
        $(location).attr('href', 'funcionarioFiltro.php');
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
        const codigo = +($("#codigo").val());
        const ativo = $("#ativo").val();
        const nome = $("#nome").val();
        const cpf = $("#cpf").val();
        const dataNascimento = $("#dataNascimento").val();
        const rg = $("#rg").val();
        const genero = $("#sexo").val() || "";
        const estadoCivil = $("#estadoCivil").val() || "";
        const cep = $("#cep").val();
        const logradouro = $("#logradouro").val();
        const uf = $("#uf").val();
        const bairro = $("#bairro").val();
        const cidade = $("#cidade").val();
        const numero = $("#numero").val();
        const complemento = $("#complemento").val() || "";
        const primeiroEmprego = $("#primeiroEmprego").val() || "";
        const pispasep = $("#pispasep").val();

        if (nome == "") {
            smartAlert("Atenção", "O nome precisa ser preenchido!", "error");
            $("#nome").focus();
            return;
        }

        if (!/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/.test(nome)) {
            smartAlert("Atenção", "O nome não é válido!", "error");
            $("#nome").focus();
            return;
        }

        if (cpf == "") {
            smartAlert("Atenção", "O CPF precisa ser preenchido!", "error");
            $("#cpf").focus();
            return;
        }

        if (!validadorCPF(cpf)) {
            smartAlert("Atenção", "CPF inválido!", "error");
            $("#cpf").val('').focus();
            return;
        }

        if (rg == "" || rg === $("#rg").attr('placeholder')) {
            smartAlert("Atenção", "O RG precisa ser preenchido!", "error");
            $("#rg").val('').focus();
            return;
        }

        if (!validaRG(rg)) {
            smartAlert("Atenção", "RG inválido!", "error");
            $("#rg").val('').focus();
            return;
        }

        if (genero == "") {
            smartAlert("Atenção", "O sexo precisa ser preenchido!", "error");
            $("#sexo").focus();
            return;
        }

        if (estadoCivil == "") {
            smartAlert("Atenção", "O estado civil precisa ser preenchido!", "error");
            $("#estadoCivil").focus();
            return;
        }

        if (dataNascimento == "") {
            smartAlert("Atenção", "A data de nascimento precisa ser preenchida!", "error");
            $("#dataNascimento").val('').focus();
            return;
        }

        if (!dataValida(dataNascimento)) {
            smartAlert("Atenção", "A data de nascimento não é válida!", "error");
            $("#dataNascimento").val('').focus();
            return;
        }

        if (primeiroEmprego === "") {
            smartAlert("Atenção", "É necessário informar se é primeiro emprego ou não", "error");
            $("#primeiroEmprego").focus();
            return;
        }

        if (primeiroEmprego == 0 && pispasep === "") {
            smartAlert("Atenção", "É necessário informar o PIS-PASEP", "error");
            $("#pispasep").focus();
            return;
        }

        if (jsonTelefoneArray.length === 0 && jsonEmailArray.length === 0) {
            smartAlert("Atenção", "É necessário adicionar pelo menos 1 contato.", "error");
            return;
        }

        if (jsonTelefoneArray.every(item => item.telPrincipal === 0) && jsonEmailArray.every(item => item.emailPrincipal === 0)) {
            smartAlert("Atenção", "É necessário pelo menos um contato principal", "error");
            return;
        }

        if (cep === "") {
            smartAlert("Atenção", "É necessário preencher o CEP", "error");
            $("#cep").focus();
            return;
        }

        if (logradouro === "") {
            smartAlert("Atenção", "É necessário preencher o logradouro", "error");
            return;
        }

        if (uf === "") {
            smartAlert("Atenção", "É necessário preencher a UF", "error");
            return;
        }

        if (bairro === "") {
            smartAlert("Atenção", "É necessário preencher o bairro", "error");
            return;
        }

        if (cidade === "") {
            smartAlert("Atenção", "É necessário preencher a cidade", "error");
            return;
        }

        if (numero === "") {
            smartAlert("Atenção", "É necessário preencher o número", "error");
            $("#numero").focus();
            return;
        }

        gravaFuncionario(codigo, ativo, nome, cpf, rg, genero, estadoCivil, dataNascimento, jsonTelefoneArray, jsonEmailArray, cep, logradouro, uf, bairro, cidade, numero, complemento, primeiroEmprego, pispasep, jsonDependenteArray);
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

        if (mes < 0 || mes === 0 && dataAtual[0] < dataNascimento[0]) {
            idade -= 1;
        }

        $("#idade").val(idade);
    }

    function dataValida(data) {
        let dataAtual = new Date();
        let nascimentoSplit = data.split('/');
        let dataNascimento = new Date(nascimentoSplit[2], nascimentoSplit[1] - 1, nascimentoSplit[0]);
        const dias30 = [4, 6, 9, 11];
        const dias31 = [1, 3, 5, 7, 8, 10, 12];
        const condicoes = [
            dataAtual.getFullYear() - 125 > dataNascimento.getFullYear(),
            dataAtual < dataNascimento,
            nascimentoSplit[1] < 0 || nascimentoSplit[1] > 12 || nascimentoSplit[0] < 1 || nascimentoSplit[1] > 31,
            dias30.includes(nascimentoSplit[1]) && nascimentoSplit[0] > 30,
            dias31.includes(nascimentoSplit[1]) && nascimentoSplit[0] > 31,
            !ehBissexto(nascimentoSplit[2]) && (nascimentoSplit[1] == 2 && nascimentoSplit[0] > 28),
            ehBissexto(nascimentoSplit[2]) && (nascimentoSplit[1] == 2 && nascimentoSplit[0] > 29)
        ];

        const valido = condicoes.every(condicao => condicao === false);
        if (!valido) {
            return false;
        }

        return true;
    }

    function ehBissexto(ano) {
        if ((ano % 4 == 0 && ano % 100 != 0) || ano % 400 == 0) {
            return true;
        }

        return false;
    }

    function validaRG(rg) {
        const invalidos = ['000000000', '111111111', '222222222', '333333333', '444444444',
            '555555555', '666666666', '777777777', '888888888', '999999999'
        ];

        if (invalidos.includes(rg.replaceAll('.', '').replaceAll('-', ''))) {
            return false;
        } else if (!/^[0-9]+$/.test(rg.replaceAll('.', '').replaceAll('-', ''))) {
            return false;
        }
        return true;
    }

    function addTelefone() {
        let item = $("#formTelefone").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataTel
        });
        item["telPrincipal"] ? item["telPrincipal"] = 1 : item["telPrincipal"] = 0;
        item["whatsapp"] ? item["whatsapp"] = 1 : item["whatsapp"] = 0;

        if (item["sequencialTel"] === '') {
            if (jsonTelefoneArray.length === 0) {
                item["sequencialTel"] = 1;
            } else {
                item["sequencialTel"] = Math.max.apply(Math, jsonTelefoneArray.map(function(o) {
                    return o.sequencialTel;
                })) + 1;
            }
            item["telefoneId"] = 0;
        } else {
            item["sequencialTel"] = +item["sequencialTel"];
        }

        var index = -1;
        $.each(jsonTelefoneArray, function(i, obj) {
            if (+$('#sequencialTel').val() === obj.sequencialTel) {
                index = i;
                return false;
            }
        });

        if (!validaTelefone()) {
            return false;
        }

        if (index >= 0)
            jsonTelefoneArray.splice(index, 1, item);
        else
            jsonTelefoneArray.push(item);

        $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
        fillTableTelefone();
        clearFormTelefone();
    }

    function validaTelefone() {
        let existe = false;
        let achou = false;
        let tel = $('#telefone').val();
        let sequencial = +$('#sequencialTel').val();
        let telefonePrincipalMarcado = $("#telPrincipal").is(":checked") ? 1 : 0;

        for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
            if (telefonePrincipalMarcado === 1) {
                if ((jsonTelefoneArray[i].telPrincipal === 1) && (jsonTelefoneArray[i].sequencialTel !== sequencial)) {
                    achou = true;
                    break;
                }
            }

            if (jsonTelefoneArray[i].telefone === tel && jsonTelefoneArray[i].sequencialTel !== sequencial) {
                existe = true;
                break;
            }
        }

        if (tel == "" || tel === $("#telefone").attr('placeholder')) {
            smartAlert("Erro", "Informe um telefone!", "error");
            return false;
        }

        if (tel.length < 14 || tel.length > 15) {
            smartAlert("Erro", "Formato de telefone inválido!", "error");
            return false;
        }

        if (achou === true) {
            smartAlert("Erro", "Já existe um telefone principal cadastrado.", "error");
            return false;
        }

        if (existe === true) {
            smartAlert("Erro", "Telefone já cadastrado.", "error");
            return false;
        }

        return true;
    }

    function fillTableTelefone() {
        $("#tableTelefone tbody").empty();
        for (var i = 0; i < jsonTelefoneArray.length; i++) {
            if (jsonTelefoneArray[i].telefone !== null && jsonTelefoneArray[i].telefone != '') {
                var row = $('<tr />');
                $("#tableTelefone tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonTelefoneArray[i].sequencialTel + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaTelefone(' + jsonTelefoneArray[i].sequencialTel + ');">' + jsonTelefoneArray[i].telefone + '</td>'));
                row.append($('<td class="text-nowrap">' + (jsonTelefoneArray[i].telPrincipal ? 'Sim' : 'Não') + '</td>'));
                row.append($('<td class="text-nowrap">' + (jsonTelefoneArray[i].whatsapp ? 'Sim' : 'Não') + '</td>'));
            }
        }
    }

    function processDataTel(node) {
        var fieldId = node.getAttribute ? node.getAttribute('id') : '';
        var fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === "telefone")) {
            var valorTel = $("#telefone").val();
            if (valorTel !== '') {
                fieldName = "telefone";
            }
            if (valorTel[valorTel.length - 1] === '_') {
                valorTel = valorTel.replace('-', '').replaceAll('_', '');
                valorTel = valorTel.substr(0, 9) + '-' + valorTel.substr(9);
            }
            return {
                name: fieldName,
                value: valorTel
            };
        }
        if (fieldName !== '' && (fieldId === "telefonePrincipal")) {
            var telefonePrincipal = 0;
            if ($("#telefonePrincipal").is(':checked') === true) {
                telefonePrincipal = 1;
            }
            return {
                name: fieldName,
                value: telefonePrincipal
            };
        }

        return false;
    }

    function excluirContato() {
        var arrSequencial = [];
        $('#tableTelefone input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonTelefoneArray.length - 1; i >= 0; i--) {
                var obj = jsonTelefoneArray[i];
                // jQuery.inArray( value, array [, fromIndex ] )
                // O método $.inArray() é semelhante ao método nativo .indexOf() do JavaScript,
                // pois retorna -1 quando não encontra uma correspondência.
                // Se o primeiro elemento da matriz corresponder ao valor, $.inArray() retornará 0.
                if (jQuery.inArray(obj.sequencialTel, arrSequencial) > -1) {
                    jsonTelefoneArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonTelefoneArray));
            fillTableTelefone();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 telefone para excluir.", "error");
    }

    function carregaTelefone(sequencialTel) {
        var arr = jQuery.grep(jsonTelefoneArray, function(item, i) {
            return (item.sequencialTel === sequencialTel);
        });

        clearFormTelefone();

        if (arr.length > 0) {
            var item = arr[0];
            $("#telefoneId").val(item.telefoneId);
            $("#sequencialTel").val(item.sequencialTel);
            $("#telefone").val(item.telefone);
            $("#telPrincipal").prop("checked", item.telPrincipal);
            $("#whatsapp").prop("checked", item.whatsapp);
        }
    }

    function clearFormTelefone() {
        $("#telefone").val("");
        $("#telefoneId").val("");
        $("#sequencialTel").val("");
        $("#telPrincipal").prop("checked", true);
        $("#whatsapp").prop("checked", false);
    }

    function addEmail() {
        let item = $("#formEmail").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataEmail
        });
        item["emailPrincipal"] ? item["emailPrincipal"] = 1 : item["emailPrincipal"] = 0;

        if (item["sequencialEmail"] === "") {
            if (jsonEmailArray.length === 0) {
                item["sequencialEmail"] = 1;
            } else {
                item["sequencialEmail"] = Math.max.apply(Math, jsonEmailArray.map(function(o) {
                    return o.sequencialEmail;
                })) + 1;
            }
            item["emailId"] = 0;
        } else {
            item["sequencialEmail"] = +item["sequencialEmail"];
        }

        let index = -1;
        $.each(jsonEmailArray, (i, obj) => {
            if (+$("#sequencialEmail").val() === obj.sequencialEmail) {
                index = i;
                return false;
            }
        });

        if (!validaEmail()) {
            return false;
        }

        if (index >= 0) {
            jsonEmailArray.splice(index, 1, item);
        } else {
            jsonEmailArray.push(item);
        }

        $("#jsonEmail").val(JSON.stringify(jsonEmailArray));
        fillTableEmail();
        clearFormEmail();
    }

    function validaEmail() {
        let existe = false;
        let achou = false;
        let email = $("#email").val();
        let sequencial = +$("#sequencialEmail").val();
        let emailPrincipalMarcado = $("#emailPrincipal").is(":checked") ? 1 : 0;
        const pattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;

        for (i = jsonEmailArray.length - 1; i >= 0; i--) {
            if (emailPrincipalMarcado === 1) {
                if (jsonEmailArray[i].emailPrincipal === 1 && jsonEmailArray[i].sequencialEmail !== sequencial) {
                    achou = true;
                    break;
                }
            }

            if (jsonEmailArray[i].email === email && jsonEmailArray[i].sequencialEmail !== sequencial) {
                existe = true;
                break;
            }
        }

        if (!pattern.test(email)) {
            smartAlert("Erro", "Formato de email inválido!", "error");
            return false;
        }

        if (email === "") {
            smartAlert("Erro", "Informe um email!", "error");
            return false;
        }

        const invalidos = ["&", "<", ">", '"'];
        let validaCaracteres = true;
        invalidos.forEach(char => {
            if (email.indexOf(char) > 0) {
                validaCaracteres = false;
            }
        });

        if (!validaCaracteres) {
            smartAlert("Atenção", 'Os caracteres (&, <, >, ") são inválidos.', "error");
            $("#email").focus();
            return;
        }

        if (achou === true) {
            smartAlert("Erro", "Já existe um email principal cadastrado.", "error");
            return false;
        }

        if (existe === true) {
            smartAlert("Erro", "Email já cadastrado!", "error");
            return false;
        }

        return true;
    }

    function fillTableEmail() {
        $('#tableEmail tbody').empty();
        for (let i = 0; i < jsonEmailArray.length; i++) {
            if (jsonEmailArray[i].email !== null && jsonEmailArray[i].email != '') {
                let row = $('<tr />');
                $('#tableEmail tbody').append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + jsonEmailArray[i].sequencialEmail + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaEmail(' + jsonEmailArray[i].sequencialEmail + ');">' + jsonEmailArray[i].email + '</td>'));
                row.append($('<td class="text-nowrap">' + (jsonEmailArray[i].emailPrincipal ? 'Sim' : 'Não') + '</td>'));
            }
        }
    }

    function processDataEmail(node) {
        let fieldId = node.getAttribute ? node.getAttribute('id') : '';
        let fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && fieldId === 'email') {
            let valorEmail = $("#email").val();
            if (valorEmail !== '') {
                fieldName = 'email';
            }
            return {
                name: fieldName,
                value: valorEmail
            };
        }

        if (fieldName !== '' && fieldId === 'emailPrincipal') {
            let emailPrincipal = 0;
            if ($('#emailPrincipal').is(':checked')) {
                emailPrincipal = 1;
            }
            return {
                name: fieldName,
                value: emailPrincipal
            };
        }

        return false;
    }

    function excluirEmail() {
        let arrSequencial = [];
        $('#tableEmail input[type=checkbox]:checked').each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonEmailArray.length - 1; i >= 0; i--) {
                let obj = jsonEmailArray[i];
                // jQuery.inArray( value, array [, fromIndex ] )
                // O método $.inArray() é semelhante ao método nativo .indexOf() do JavaScript,
                // pois retorna -1 quando não encontra uma correspondência.
                // Se o primeiro elemento da matriz corresponder ao valor, $.inArray() retornará 0.
                if (jQuery.inArray(obj.sequencialEmail, arrSequencial) > -1) {
                    jsonEmailArray.splice(i, 1);
                }
            }
            $("#jsonTelefone").val(JSON.stringify(jsonEmailArray));
            fillTableEmail();
        } else
            smartAlert("Erro", "Selecione pelo menos 1 email para excluir.", "error");
    }

    function carregaEmail(sequencialEmail) {
        let arr = jQuery.grep(jsonEmailArray, function(item, i) {
            return (item.sequencialEmail === sequencialEmail);
        });

        clearFormEmail();

        if (arr.length > 0) {
            let item = arr[0];
            $("#emailId").val(item.emailId);
            $("#sequencialEmail").val(item.sequencialEmail);
            $("#email").val(item.email);
            $("#emailPrincipal").prop("checked", item.emailPrincipal);
        }
    }

    function clearFormEmail() {
        $("#email").val("");
        $("#emailId").val("");
        $("#sequencialEmail").val("");
        $("#emailPrincipal").prop("checked", true);
    }

    async function preencheEndereco(cep) {
        const url = `https://viacep.com.br/ws/${cep}/json/`
        const res = await fetch(url, {
            method: 'GET'
        });
        const data = await res.json();

        $("#logradouro").val(data.logradouro);
        $("#bairro").val(data.bairro);
        $("#uf").val(data.uf);
        $("#cidade").val(data.localidade);
        $("#numero").focus();
    }

    function clearEndereco() {
        $("#logradouro").val('');
        $("#uf").val('');
        $("#bairro").val('');
        $("#cidade").val('');
        $("#numero").val('');
        $("#cep").focus();
    }

    function addDependente() {
        const item = $("#formDependente").toObject({
            mode: 'combine',
            skipEmpty: false,
            nodeCallback: processDataDep
        });
        item["descricaoTipo"] = $("#tipoDependente option:selected").text();

        if (item['sequencialDep'] === '') {
            if (jsonDependenteArray.length === 0) {
                item['sequencialDep'] = 1;
            } else {
                item['sequencialDep'] = Math.max.apply(Math, jsonDependenteArray.map(function(o) {
                    return o.sequencialDep;
                })) + 1;
            }
            item['dependenteId'] = 0;
        } else {
            item['sequencialDep'] = +item['sequencialDep'];
        }

        let index = -1;
        $.each(jsonDependenteArray, function(i, obj) {
            if (+$('#sequencialDep').val() === obj.sequencialDep) {
                index = i;
                return false;
            }
        });

        if (!validaDependente()) {
            return false;
        }

        if (index >= 0) {
            jsonDependenteArray.splice(index, 1, item);
        } else {
            jsonDependenteArray.push(item);
        }

        $("#jsonDependentes").val(JSON.stringify(jsonDependenteArray));
        fillTableDependente();
        clearFormDependente();
    }

    function validaDependente() {
        let existe = false;
        const nome = $("#nomeDependente").val();
        const cpfDependente = $("#cpfDependente").val();
        const dataNasimento = $("#dataNascimentoDependente").val();
        const tipoDependente = $("#tipoDependente").val() || "";
        let sequencial = +$("#sequencialDep").val();
        const cpfFuncionario = $("#cpf").val();

        if (nome == "") {
            smartAlert("Erro", "É necessário preencher o nome.", "error");
            $("#nomeDependente").focus();
            return false;
        }

        if (cpfDependente == cpfFuncionario) {
            smartAlert("Erro", "Não é possível cadastrar o CPF do funcionário como dependente.", "error");
            return false;
        }

        if (!/[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/.test(nome)) {
            smartAlert("Atenção", "O nome não é válido!", "error");
            $("#nome").focus();
            return;
        }

        if (cpfDependente == "" || cpfDependente == $("#cpfDependente").attr('placeholder')) {
            smartAlert("Erro", "É necessário informar o CPF.", "error");
            $("#cpfDependente").focus();
            return false;
        }

        if (!validadorCPF(cpfDependente)) {
            return false;
        }

        if (dataNasimento == "" || dataNasimento == $("#dataNascimentoDependente").attr('placeholder')) {
            smartAlert("Erro", "É necessário informar a data de nascimento.", "error");
            $("#dataNascimentoDependente").focus();
            return false;
        }

        if (!dataValida(dataNasimento)) {
            return false;
        }

        if (tipoDependente == "") {
            smartAlert("Erro", "É necessário selecionar o tipo de dependente.", "error");
            $("#tipoDependente").focus();
            return false;
        }

        return true;
    }

    function fillTableDependente() {
        $("#tableDependentes tbody").empty();
        for (let i = 0; i < jsonDependenteArray.length; i++) {
            const nome = jsonDependenteArray[i].nomeDependente;
            const cpf = jsonDependenteArray[i].cpfDependente;
            const dataNascimento = jsonDependenteArray[i].dataNascimentoDependente;
            const descricaoDependente = jsonDependenteArray[i].descricaoTipo;
            const sequencialDep = jsonDependenteArray[i].sequencialDep;
            if ((nome !== null && nome !== '') &&
                (cpf !== null && cpf !== '') &&
                (dataNascimento !== null && dataNascimento !== '') &&
                (tipoDependente !== null && tipoDependente !== '')) {
                const row = $("<tr />");
                $("#tableDependentes tbody").append(row);
                row.append($('<td><label class="checkbox"><input type="checkbox" name="checkbox" value="' + (sequencialDep) + '"><i></i></label></td>'));
                row.append($('<td class="text-nowrap" onclick="carregaDependente(' + (sequencialDep) + ');">' + nome + '</td>'));
                row.append($('<td class="text-nowrap">' + (cpf) + '</td>'));
                row.append($('<td class="text-nowrap">' + (dataNascimento) + '</td>'));
                row.append($('<td class="text-nowrap">' + (descricaoDependente) + '</td>'));
            }
        }
    }

    function processDataDep(node) {
        let fieldId = node.getAttribute ? node.getAttribute('id') : '';
        let fieldName = node.getAttribute ? node.getAttribute('name') : '';

        if (fieldName !== '' && (fieldId === 'nomeDependente')) {
            const valorNomeDep = $('#nomeDependente').val();
            if (valorNomeDep !== '') {
                fieldName = 'nomeDependente';
            }

            return {
                name: fieldName,
                value: valorNomeDep
            };
        }

        if (fieldName !== '' && (fieldId === 'cpfDependente')) {
            const valorCpfDep = $("#cpfDependente").val();
            if (valorCpfDep !== '') {
                fieldName = 'cpfDependente';
            }

            return {
                name: fieldName,
                value: valorCpfDep
            };
        }

        if (fieldName !== '' && (fieldId === 'dataNascimentoDependente')) {
            const dataNascimentoDep = $("#dataNascimentoDependente").val();
            if (dataNascimentoDep !== '') {
                fieldName = 'dataNascimentoDependente';
            }

            return {
                name: fieldName,
                value: dataNascimentoDep
            };
        }

        if (fieldName !== '' && (fieldId === 'tipoDependente')) {
            const tipo = $("#tipoDependente").val();
            if (tipo !== '') {
                fieldName = 'tipoDependente';
            }

            return {
                name: fieldName,
                value: tipo
            };
        }

        return false;
    }

    function excluirDependente() {
        const arrSequencial = [];
        $("#tableDependentes input[type=checkbox]:checked").each(function() {
            arrSequencial.push(parseInt($(this).val()));
        });
        if (arrSequencial.length > 0) {
            for (i = jsonDependenteArray.length - 1; i >= 0; i--) {
                const obj = jsonDependenteArray[i];
                if (jQuery.inArray(obj.sequencialDep, arrSequencial) > -1) {
                    jsonDependenteArray.splice(i, 1);
                }
            }
            $("#jsonDependentes").val(JSON.stringify(jsonDependenteArray));
            fillTableDependente();
        } else {
            smartAlert("Erro", "Selecione pelo menos 1 dependente para excluir", "error");
        }
    }

    function carregaDependente(sequencialDep) {
        const arr = jQuery.grep(jsonDependenteArray, function(item, i) {
            return (item.sequencialDep === sequencialDep);
        });

        clearFormDependente();

        if (arr.length > 0) {
            const item = arr[0];
            $("#dependenteId").val(item.dependenteId);
            $("#sequencialDep").val(item.sequencialDep);
            $("#nomeDependente").val(item.nomeDependente);
            $("#cpfDependente").val(item.cpfDependente);
            $("#dataNascimentoDependente").val(item.dataNascimentoDependente);
            $("#tipoDependente").val(item.tipoDependente);
        }
    }

    function clearFormDependente() {
        $("#nomeDependente").val('');
        $("#cpfDependente").val('');
        $("#dataNascimentoDependente").val('');
        $("#tipoDependente").val('');
        $("#dependenteId").val('');
        $("#sequencialDep").val('');
    }

    function validadorCPF(cpf) {
        if (cpf == '') {
            return false;
        }

        cpf = cpf.replaceAll('.', '');
        cpf = cpf.replaceAll('-', '');

        if (cpf.length != 11) {
            return false;
        } else if (cpf == '00000000000' ||
            cpf == '11111111111' ||
            cpf == '22222222222' ||
            cpf == '33333333333' ||
            cpf == '44444444444' ||
            cpf == '55555555555' ||
            cpf == '66666666666' ||
            cpf == '77777777777' ||
            cpf == '88888888888' ||
            cpf == '99999999999') {
            return false;
        } else {
            for (t = 9; t < 11; t++) {
                for (d = 0, c = 0; c < t; c++) {
                    d += cpf[c] * ((t + 1) - c);
                }
                d = ((10 * d) % 11) % 10;
                if (cpf[c] != d) {
                    return false;
                }
            }
            return true;
        }
    }
</script>