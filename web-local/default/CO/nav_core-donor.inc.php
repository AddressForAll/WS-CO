<link rel="stylesheet" href="/resources/css/api.css">
<section class="main-api" id="api">
    <h1>API - Resgatar dados</h1>
    <span>
        <strong>Dados: </strong>Donors
    </span>
    <br>
    <label><strong>Paginar Resultado: </strong></label><input type="checkbox" id="paginar" checked>
    <br>
    <button onclick="getdata();"><strong>Consultar</strong></button>
    <br>
    <br>
    <table id="tabela" class="display" style="display: none;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Scope</th>
                <th>Id Vat</th>
                <th>Short Name</th>
                <th>Legal Name</th>
                <th>Id Wikidata</th>
                <th>Donations</th>
            </tr>
        </thead>
    </table>
    <div id="definepaginacao" style="display: none;">
        <strong>Configurar resultados por página</strong>
        <select id="paginacao">
            <option value="10" selected>10</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="-1">Mostrar tudo</option>
        </select>
    </div>

    <br><br>
    <div class="desenvolvedor">
        <table>
            <tr>
                <th colspan="2">Annotations for Developers</th>
            </tr>
            <tr>
                <td>data</td><td>: donor</td>
            </tr>
            <tr>
                <td>GET</td><td>: <a id="get_url" style="text-decoration: none" href="http://api-test.addressforall.org/v1/vw_core/donor/">
                http://api-test.addressforall.org/v1/vw_core/donor/</a></td>
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
<script src="/resources/js/api-donor.js"></script>

