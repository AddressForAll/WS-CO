<link rel="stylesheet" href="/resources/css/api.css">
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
<section class="main-api" id="api">
    <h1>API - Resgatar dados</h1>
    <span>
        <strong>Dados: </strong>Jurisdiction
    </span>
    <h3>&#x2198; Especificações de Entrada</h3>
    <div class="parametros">
        <form action="/v1.htm/nav_core/jurisdiction/" method="GET">
            <!-- COMBOS -->
            <div id="div_abbrev" style="">
                <label><strong>Parent Abbrev: </strong></label>
                <select name="abbrev" id="abbrev"></select>
            </div>
            <hr style="opacity: 0.1;">
            <button onclick="getdata();"><strong>Consultar</strong></button>
            </br>
        <form>
    </div>
    <div id="definepaginacao" style="display: none;">
        <h3>&#x2197; Especificações de Saída</h3>
        <div class="parametros">
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
    <br>
    <br>

    <table id="tabela" class="display" style="display: none;">
        <thead>
            <tr>
                <th>osm_id</th>
                <th>jurisd_base_id</th>
                <th>jurisd_local_id</th>
                <th>name</th>
                <th>parent_abbrev</th>
                <th>abbrev</th>
                <th>wikidata_id</th>
                <th>lexlabel</th>
                <th>isolabel_ext</th>
                <th>ddd</th>
                <th>info</th>
                <th>admin_level</th>
                <th>parent_id</th>            
            </tr>
        </thead>
    </table>
    <br><br>
    <div class="desenvolvedor">
        <table>
            <tr>
                <th colspan="2">Annotations for Developers</th>
            </tr>
            <tr>
                <td>data</td><td>: jurisdiction</td>
            </tr>
            <tr>
                <td>GET</td><td>: <a id="get_url" style="text-decoration: none" href="http://api-test.addressforall.org/v1.htm/vw_core/donor">http://api-test.addressforall.org/v1.htm/vw_core/donor</a></td>
            </tr>
            <tr>
                <td>doc</td>
                <td>: <a target="_blank" rel="external" href="https://github.com/AddressForAll/WS" style="text-decoration: none">https://github.com/AddressForAll/WS</a></td>
            </tr>
        </table>
    </div>
</section>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/sp-1.1.1/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"/>
<script src="/resources/js/api-jurisdiction.js"></script>
