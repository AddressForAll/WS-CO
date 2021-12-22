<style>
    .parametros{
        background-color: #e9e9e9;
        border-radius: 10px;
        margin: 1em;
        padding: 1em;
    }
    td.details-control {
        background: url('/resources/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/resources/img/details_close.png') no-repeat center center;
    }
</style>
<link rel="stylesheet" href="/resources/css/api.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/sp-1.1.1/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"/>

<section class="main-api" id="api">
    <h1>Resultado da solicitação de API</h1>
        
    <div id="definepaginacao">
        <h3>&#x2197; Especificações de Saída</h3>
        <div class="parametros">
            <strong>Paginar Resultado: </strong><input type="checkbox" id="paginar" checked>
            <strong>Configurar resultados por página</strong>
            <select id="paginacao">
                <option value="10" selected>10</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
                <option value="-1">Mostrar tudo</option>
            </select>
        </div>
    </div>
    </br>
    <table id="api_default_preview" class="display compact" style="width:100%"></table>
<script>

    const links = {
        "wikidata_id" : "http://wikidata.org/entity/Q",
        "osm_id" : "http://osm.org/relation/"
    }

    function getColumn(column){
        return (typeof links[column] === "undefined") ? {data: column} : getLink(column);
    }

    function getLink(column){
        return {
            "title" : column,
            "data" : null,
            "render" : data=> (data[column]) ? `<a href="${links[column]}${data[column]}" target_blank>${data[column]}</a>` : ''
        }
    }

    /* Formatting function for row details - modify as you need */
    function format (row , column_json) {
        let html =  '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        for(var item in row[column_json])
            html += '<tr><td>' + item + '</td><td>' + row[column_json][item] + '</td></tr>';

        return html + '</table>';
    }

    function createTableHeader(tableNode, headItems){
        var tbody = document.createElement('tbody');
        var thead = document.createElement('thead');
        var tr, td;
        tr = document.createElement('tr');
        for (var item of headItems){
            let th = document.createElement('th');
            th.innerHTML = ((item["data"]) ? item["data"] : item["title"]);
            tr.appendChild(th);
        }
        thead.appendChild(tr);
        tableNode.appendChild(thead);
    }

    $.getJSON(data_url, function(data) { // this variable `data_url` is defined during index.php call
        var columns = [];
        var object_json_column = null;

        // Creating columns array
        for (var i in data[0]){
            if (typeof(data[0][i]) === 'object' && data[0][i]){
                 
                let attr = 
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                    "title" : i
                }
                object_json_column = i; 
                columns.push(attr);
            }
            else
                columns.push(getColumn(i));
        }
        
        // Creating table head HTML according with `columns` array above  
        createTableHeader(document.getElementById('api_default_preview'), columns);

        // DataTable settings 
        var table = $('#api_default_preview').DataTable({
                    "data": data,
                    "bDestroy": true,
                    "dom": 'Bfrtip',
                    "buttons": ['copy', 'csv', 'excel'],
                    "columns" : columns,
                    "paging": $('#paginar').prop('checked'),
                    "responsive": true,
                    "pageLength" : 10
                });

        // Calling the function that build the html and render  
        $('#api_default_preview tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data(), object_json_column) ).show();
                tr.addClass('shown');
            }
        });

        // Páginação controlda
        $('#paginacao').on('change', ()=> {
            qtd = $("#paginacao").children("option:selected").val()
            $('#api_default_preview').DataTable().page.len(qtd).draw()
        });

        $('#paginar').on('change', ()=> {
            if (!$('#paginar').prop('checked'))
                $('#api_default_preview').DataTable().page.len(-1).draw()
            else if (qtd)
                $('#api_default_preview').DataTable().page.len(qtd).draw()
            else
                $('#api_default_preview').DataTable().page.len(10).draw()
        });
    }); // END getJSON
</script>

<!-- ADDING ANNOTATION FOR DEVS --> 
<?= include_once("default/api_default_devFoot.inc.php") ?>

</section>
