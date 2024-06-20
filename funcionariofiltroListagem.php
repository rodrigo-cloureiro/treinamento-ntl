<?php
include "js/repositorio.php";
include "js/girComum.php";
?>
<div class="table-container">
    <div class="table-responsive" style="min-height: 115px; border: 1px solid #ddd; margin-bottom: 13px; overflow-x: auto;">
        <table id="tableSearchResult" class="table table-bordered table-striped table-condensed table-hover dataTable">
            <thead>
                <tr role="row">
                    <th class="text-left" style="min-width:30px;">Nome</th>
                    <th class="text-left" style="min-width:35px;">CPF</th>
                    <th class="text-left" style="min-width:30px;">Data de Nascimento</th>
                    <th class="text-left" style="min-width:35px;">Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $utils = new comum();
                $ativoFiltro = $_POST["ativoFiltro"];
                $nomeFiltro = $_POST["nomeFiltro"];
                $cpfFiltro = $_POST["cpfFiltro"];
                $estadoCivilFiltro = $_POST["estadoCivil"];
                $sexoFiltro = $_POST["sexo"];
                // $dataNascimentoFiltro = $utils->formatarDataSql($_POST["dataNascimentoFiltro"]);
                $dataInicioFiltro = $utils->formatarDataSql($_POST["dataInicio"]);
                $dataFimFiltro = $utils->formatarDataSql($_POST["dataFim"]);
                $where = "WHERE (0 = 0)";

                if ($ativoFiltro != "") {
                    $where = $where . " AND f.ativo = $ativoFiltro";
                } 
                
                if ($nomeFiltro != "") {
                    $where = $where . " AND f.nome like replace('%$nomeFiltro', ' ', '') + '%'";
                } 
                
                if ($cpfFiltro != "") {
                    $where = $where . " AND f.cpf ='$cpfFiltro'";
                }

                if ($estadoCivilFiltro != "") {
                    $where = $where . " AND ec.codigo = $estadoCivilFiltro";
                }

                if ($sexoFiltro != "") {
                    $where = $where . " AND s.codigo = $sexoFiltro";
                }
                
                // if ($dataNascimentoFiltro != "NULL") {
                //     $where = $where . " AND dataNascimento = $dataNascimentoFiltro";
                // }

                if ($dataInicioFiltro != "NULL" && $dataFimFiltro != "NULL") {
                    $where = $where . " AND dataNascimento BETWEEN $dataInicioFiltro AND $dataFimFiltro";
                } else if ($dataInicioFiltro != "NULL") {
                    $where = $where . " AND dataNascimento >= $dataInicioFiltro";
                } else if ($dataFimFiltro != "NULL") {
                    $where = $where . " AND dataNascimento <= $dataFimFiltro";
                }

                $sql = " SELECT f.codigo, f.ativo, f.nome, f.cpf, f.dataNascimento, s.codigo, s.descricao
                         FROM cadastro.dbo.funcionarios f
                         JOIN cadastro.dbo.estado_civil ec ON f.estadoCivil = ec.codigo
                         JOIN cadastro.dbo.sexo s ON f.genero = s.codigo ";
                // $where = $where . " AND USU.tipoUsuario = 'C' ";

                $sql = $sql . $where;
                // $sql = $sql;
                $reposit = new reposit();
                $utils = new comum();
                $result = $reposit->RunQuery($sql);

                foreach($result as $row) {
                    $id = (int) $row['codigo'];
                    $nome = $row['nome'];
                    $ativo = (int) $row['ativo'];
                    $cpf = $row['cpf'];
                    $dataNascimento = $utils->validaDataInversa($row['dataNascimento']);
                    $descricaoAtivo = "";
                    if ($ativo == 1) {
                        $descricaoAtivo = "Sim";
                    } else {
                        $descricaoAtivo = "Não";
                    }

                    echo '<tr >';
                    echo '<td class="text-left"><a href="funcionarioCadastro.php?id=' . $id . '">' . $nome . '</a></td>';
                    echo '<td class="text-left">' . $cpf . '</td>';
                    echo '<td class="text-left">' . $dataNascimento . '</td>';
                    echo '<td class="text-left">' . $descricaoAtivo . '</td>';
                    echo '</tr >';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        /* TABLETOOLS */
        $('#tableSearchResult').dataTable({
            // Tabletools options: 
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sLengthMenu": "_MENU_ Resultados por página",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "oTableTools": {
                "aButtons": ["copy", "csv", "xls", {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth": true,
            "preDrawCallback": function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#tableSearchResult'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

    });
</script>