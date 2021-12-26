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
    <h1>ECLUSA DE DADOS</h1>
    <img style="float: right;" src="/resources/img/nav-eclusa.png"" alt="Eclusa de Dados" width="180" height="200">
    <p>A entrega de <a href="http://addressforall.org/dados">dados brutos</a> pode ser realizada arquivo por arquivo na API ou "em lote", ambas pelo técnico responsável devidamente autenticado. A "entrega em lote" é realizada por protocolo SFTP, no ambiente apelidado de Eclusa, garantindo-se o seguinte workflow:
      <ol>
          <li>O técnico responsável recebe os dados originais, os revisa e os organiza.</li>
          <li>O técnico responsável efetua na sua home SFTP <code>/home/{user}</code> dos arquivos desejados nas pastas padronizadas.</li>
          <li>O software da Eclusa cria hashes e leva os metadados para a base de dados, depois de oferecer recursos de confirmação na API. Os dados ficam preservados em área de quarentena (períorodo de embargo e testes) e depois em repositório definitivo para a preservacao digital.</li>
      </ol>
    </p>
    <p>Seguindo alguns dos princípios gerais das "eclusas de <b>segurança de dados</b>"
      (<a href="https://cidacs.bahia.fiocruz.br/plataforma-de-dados/" rel="external" target="_blank">exemplo</a>),
      a <b>integridade</b> dos dados originais e a segurança juridica (fé publica e custodia) da origem são garantidas pela metodologia e sua implementacao no sistema. Garante-se Firewall, restrição geral de acesso, e monitoramento publico (via API).
    </p><p>O controle de acesso ao SFTP é realizado pela <i>eclusa</i>, com intertravamento (somente permite passagem para o passo-2 com o fechamento dos demais),
      e sistema de preservação &mdash; uma vez registrada a integridade SHA256 do arquivo não há  como remover ou adulterar.
      <br/>O número de <a href="http://api-test.addressforall.org/_sql/auth_user">usuários com acesso à Eclusa</a> é restrito, sendo que todos eles recebem orientações
      e sensibilização em Integridade e Segurança da Informação, além de assinar termos de responsabilidade.
      O usuário designado para um pacote é responsavel pela confirmacao da lincenca de uso e  integridade, assumindo a responsabilidade por toda a <i>cadeia de custodia</i> do pacote.
    </p>
    <h1>APIs da Eclusa</h1>
    <h3>&#x2198; Especificações de Entrada</h3>
    <div class="parametros">
        <span>
            <strong>Filtrar por: </strong>
        </span>
        <input type="radio" id="step_0" name="tipo_do_filtro" value="step0">
            <label for="step_0">Step 1</label>
        <input type="radio" id="step_1" name="tipo_do_filtro" value="step1" checked>
            <label for="step_1">Step 2</label>
        <input type="radio" id="step_2" name="tipo_do_filtro" value="step2">
            <label for="step_2">Step 3</label>
        <br>
        <label for="usuario"><strong>Usuário: </strong></label>
        <input type="text" id="usuario" name="usuario" placeholder="Insira um usuário..." autofocus>
        <div id="tipo_de_usuario_div">
            <strong>Tipo: </strong>
            <input type="radio" id="r_todos" name="tipo_de_usuario" value="" checked>
            <label for="r_todos">Todos</label>
            <input type="radio" id="r_invalidos" name="tipo_de_usuario" value="0">
            <label for="r_invalidos">Inválidos</label>
            <input type="radio" id="r_validos" name="tipo_de_usuario" value="1">
            <label for="r_validos">Válidos</label>
        </div>
        <hr style="opacity: 0.1;">
        <button onclick="getdata();"><strong>Consultar</strong></button>
        <br>
    </div>
    <div id="definepaginacao" style="display: none;">
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

    <br>
    <table id="tabela" class="display" style="display: none;">
        <thead>
            <tr>
                <th>ISO Label Extended</th>
                <th>File Id</th>
                <th>File Name</th>
                <th>Is Valid</th>
                <th>C Type</th>
                <th>Pack Id</th>
            </tr>
        </thead>
    </table>
    <table id="tabela_step_0" class="display" style="display: none;">
        <thead>
            <tr>
                <th title="Pack Info"></th>
                <th>Username</th>
                <th>Jurisdiction_label</th>
                <th>Jurisdiction_osmid</th>
                <th>Pack Id</th>
                <th>Pack_path</th>
                <th>User_resp</th>
                <th>Accepted_date</th>
            </tr>
        </thead>
    </table>
    <br>
    <div class="desenvolvedor">
        <table>
            <tr><th colspan="2">Annotations for Developers</th></tr>
            <tr><td>Module</td><td>: <i><?=($apiPrefix1 == '') ? 'Navegação' : $apiPrefix1?></i></td></tr>
            <tr><td>Function</td><td>: <i><?=($apiPrefix2 == '') ? 'Navegação' : $apiPrefix2?></i></td></tr>
            <tr><td>URI parameters</td><td>: <i><?=($apiUri == '') ? 'Navegação' : $apiUri?></i></td></tr>
            <tr>
                <td>GET</td><td>: <a id="get_url" style="text-decoration: none" href="http://api.addressforall.org/v1/eclusa/checkUserFiles-step{step}/{user}">http://api.addressforall.org/v1/eclusa/checkUserFiles-step{step}/{user}</a></td>
            </tr>
            <tr>
                <td>docs</td>
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
<script src="/resources/js/api-eclusa.js"></script>
