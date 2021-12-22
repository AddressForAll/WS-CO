<section class="main" id="dados">
  <div>
    <h1>Dados</h1>
    <p>
      No contexto Brasil os dados disponibilizados pelo Instituto AddressForAll podem ser baixados por
      município (dados locais) ou ao nível nacional. Entanda a seguir o processo de tratamento e como
      estes dados sao armazenados e disponibilizados.
    </p>

    <div class='buttons-dados'>
      <button
      title="Dados ja tratados  pelo Instituto para download, navegando pelo mapa hierarquico de unidades adninistrativas"
      onclick="alert('aguarde final de Novembro')">Dados consolidados para <br/><i>download</i> por município (mapa)</button>
      <button
      title="Dados ja tratados  pelo Instituto para download, navegando por doador/fornecedor dos dados"
      onclick="alert('aguarde final de Novembro')">Dados consolidados para <br/>&nbsp;&nbsp;<i>download</i>  por fornecedor&nbsp;&nbsp;</button>
    </div>

<hr/>

    <h2>Fluxo geral e repositorios de dados</h2>
    <p>
      O Instituto recebe dados doados por diversas fontes, tais como prefeituras, IBGE, e OpenStreetMap,
      que publicam ou transferem por licença aberta (CC0, ODbL ou outra) os dados que produzem.
    </p>
    <div style='text-align:center'><img src='resources/img/datafigs-flow1.svg'></div>

    <p>Os dados do sistema de preservação digital são de uso geral (diversos projetos), e, uma vez homologados, recebem tratamento e garantia de conservação por pelo menos 20 anos.</p>

    <p>A segurança e integridade dos dados preservados são garantidas pelo <a href="http://api-test.addressforall.org/v1.htm/nav_eclusa/">sistema de Eclusa</a>,
      pela <a href="https://medium.com/d/aabea5389f4b" rel="external" target="_blank">integridade SHA256</a> a cada arquivo, e pela confirmação pública (seguida de depósito legal na <a href="https://www.bn.gov.br/sobre-bn/deposito-legal" rel="external" target="_blank">Fundação Biblioteca Nacional</a>).
      Em caso de arquivo obtido por <i>download</i> de site oficial, datação e registro da URL de acesso é feita através da <a href="https://archive.org/" rel="external" target="_blank"><i>Wayback Machine</i></a>.
    </p>
    <h2>Dados a cada projeto</h2>
    <p>
      A Plataforma de Projetos do Instituto AddressForAll consome os dados preservados pelo <a href="http://git.AddressForAll.org/digital-preservation">Projeto Digital Preservation</a>.
      Cada projeto faz seu proprio recorte e filtragem de dados preservados.
    </p>
    <style>
      table.qtstatus {  border: 2px solid #888; }
      table.qtstatus td {text-align: center;}
      table.qtstatus td.smallLabel {text-align: left; font-size: 75%;}
      /*
      table.qtstatus tr.totFile td:not(.smallLabel) {font-weight:bold;}
      table.qtstatus tr td:nth-child(3) {text-align: center;}
      table.qtstatus tr td:nth-child(4) {text-align: right;} */
    </style>

    <div id="qtstatus_container" style="text-align:center; align:center"></div>

    <script type="text/javascript">
    // // // small LIBRARY:
    function jsTpl(strings, ...keys) {
        return (function(...values) {
          let dict = values[values.length - 1] || {};
          let result = [strings[0]];
          keys.forEach(function(key, i) {
            let value = Number.isInteger(key) ? values[key] : dict[key];
            result.push(value, strings[i + 1]);
          });
          return result.join('');
        });
      }
      // // // \small LIBRARY

      const qtstatus_container = document.getElementById('qtstatus_container')
      const preTpl_tr0 = jsTpl`
      <tr><td width="65"></td>
         <td width="30%"><a href="${'url1'}">${'desc1'}</a></td>
         <td width="30%"><a href="${'url2'}">${'desc2'}</a></td>
         <td width="30%"><a href="${'url3'}">${'desc3'}</a></td>
      </tr>`;
      const preTpl_tab = jsTpl`
      <table class="qtstatus" border="0" align="center">
        <caption style="caption-side:top;">Projeto ${'prjName'}, status atual</caption>
        ${'tr0'}
        <tr><td width="65"></td><td colspan="3"><img src='/resources/img/datafigs-flow2-tabPad.svg'></td></tr>
        <tr class="totFile"><td class="smallLabel">Qt. arquivos: </td>
          <td width="31%"><b>${'preserv_n'}</b> (<b>${'preserv_packs'}</b> <i>packs</i>)</td>
          <td width="30%"><b>{{in_n}}</b></td>
          <td width="30%"><b>{{out_n}}</b></td>
        </tr>
        <tr class="totFile"><td class="smallLabel">Mega bytes: </td>
          <td><b>${'preserv_mb'}</b> (zipped)</td>
          <td><b>{{in_mb}}</b></td>
          <td><b>{{out_mb}}</b></td>
        </tr>
      </table>
      <p>Mais detalhes, ver <a href="http://api-test.addressforall.org/v1.htm/nav_core/origin">API <code style="font-size:75%">/v1.htm/nav_core/origin</code></a>.</p>
      `;

      const api_url1 = 'http://api-test.addressforall.org/_sql/origin_agg1'
      // falta query origin_agg1 filtrar recorte do AddressForAll, que tem origem no BR-in!
      fetch( api_url1 )
        .then( body => body.json() )
        .then( data => {
            if (Array.isArray(data)) { for(const res of data) if (typeof res == 'object') {
                url_ref = 'http://git.AddressForAll.org'
                let tr0 = preTpl_tr0({
                  url1:`${url_ref}/digital-preservation-${res.country}`, desc1:`dig. preserv. ${res.country}`,
                  url2:`${url_ref}/in-${res.country}`,  desc2:`in-${res.country}`,
                  url3:`${url_ref}/out-${res.country}`, desc3:`out-${res.country}`
                });
                let html_table = preTpl_tab({
                  prjName:    'AddressForAll '+res.country,
                  tr0:        tr0,
                  preserv_packs: res.orig_n_packs,
                  preserv_n:  res.orig_n_files,
                  preserv_mb: res.orig_mb
                });
                qtstatus_container.insertAdjacentHTML('beforeend', html_table);
              } else alert("error 2 on fetch "+api_url1)
            } else alert("error 1 on fetch "+api_url1)
        });
        // OSM.CODES? const api_url1 = 'http://api-test.addressforall.org/_sql/origin_agg1' ?
        // geral é https://github.com/datasets/country-codes BR é  datasets.ok.br.
    </script>

    <!-- #### -->
    <h1>Dados do Projeto Digital Preservation</h1>
    <p>O foco da preservacao digital sao "pacotes de dados" cedidos ao dominio publico por um fornecedor de dados primarios,
      que detem o direito de licenciar grandes quantidades de dados espaciais.
      Os dados de interesse do Instituto AddressForAll sao eleitos atraves de uma <b>curadoria</b>
      e submetidos a um <b>processo de convide e selecao</b>.
    </p>
    <p>O Projeto Digital Preservation e mantido publicamente em <a href="http://git.AddressForAll.org/digital-preservation"><code>git.AddressForAll.org/digital-preservation</code></a>,
      e as curadoriais locais de cada pais sao soberanas nas suas decisoes, em geral
      seguindo de perto ou tendo participacao efetiva de membros da comunidade OpenStreetMap do pais.
      Cada curadoria local tem autonomia de governanca, cumprindo, como entendidade federada, as diretivas gerais do Projeto.
    </p>
    <p>Por exemplo a Curadoria Brasil gerencia seu proprio repositorio em
      <a href="http://git.AddressForAll.org/digital-preservation-BR"><code>git.AddressForAll.org/digital-preservation-BR</code></a>. Os dados do repositorios sao tambem obtidos via API:
      <ul>
        <li><b>Pacotes de dados</b> obtidos pela curadoria Brasil: <a href="http://api-test.AddressForAll.org/v1.htm/vw_core/origin/BR"><code>http://api-test.AddressForAll.org/v1.htm/vw_core/origin/BR</code></a></li>
        <li><b>Doadores de pacotes</b> selecionados pela curadoria Brasil: <a href="http://api-test.AddressForAll.org/v1.htm/vw_core/donor/BR"><code>http://api-test.AddressForAll.org/v1.htm/vw_core/donor/BR</code></a></li>
      </ul>

    </p>

    <!-- #### -->
    <h1>Dados do Projeto AddressForAll</h1>
    <p>Em estreita colaboracao em a equipe do Projeto de Preservacao, a equipe de processamento de dados do Projeto AddressForAll
      segue o <i>workflow</i> ilustrado abaixo, para a selecao e ingestao dos dados, que depois de homologados ficam disponiveis em <a href="https://github.com/AddressForAll/in-BR">no git in-BR</a>.
    </p>
    <div style='text-align:center'><img src='resources/img/workflow1-preservIngest.png'></div>
    <p>Abaixo o ciclo principal de processamento nos dados relativos a pontos de endereco, reunidos e consolidados pelo projeto.</p>

    <div class="container">


      <div class="timeline-item" step='Passo 1'>
        <h1>Verificação</h1>
        <p>
          AddressForAll ao receber dados, começa por verificar a licença destes dados (procura-se dados com licença aberta (CC0) ou CCBYSA ou Odbl.
        </p>
        <p>AddressForAll pode ainda receber dados privados que poderão ser utilizados para alguns serviços providos pelo Instituto de maneira anonima.</p>
        <div class='dados-passo passo1'><img src='resources/img/passo1.1.png'><img src='resources/img/passo1.2.png'></div>
      </div>

      <div class="timeline-item" step='Passo 2'>
        <h1>Integridade</h1>
        <p>AddressForAll garante a integridade destes dados, armazenando eles de maneira segura por um prazo de 30 anos
        </p>
        <div class='dados-passo passo2'><img src='resources/img/passo2.png'></div>
      </div>

      <div class="timeline-item" step='Passo 3'>
        <h1>Tratamento</h1>
        <p>
          AddressForAll trata os dados limpando e organizando-os
        </p>
        <div class='dados-passo passo3'><img src='resources/img/passo3.1.png'><img src='resources/img/passo3.2.png'></div>
      </div>

      <div class="timeline-item" step='Passo 4'>
        <h1>Normalização</h1>
        <p>
          AddressForAll extrai da combinação dos dados um dado "otimizado" utilizado pelo AddressForAll para prover serviços otimizados através de API. Por exemplo a API de Geolocalização que retorna uma latitude / Longitude quando lhe é submetido um endereço postal.
        </p>
        <div class='dados-passo passo4'><img src='resources/img/passo4.png'></div>
      </div>

    </div>

  </div>
</section>
