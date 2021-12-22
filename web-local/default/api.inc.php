<section class="main" id="dados">
    <h1>API</h1>
    <p>
      As APIs do Portal do Instituto AddressForAll correspondem a funcionalidades de acesso direto ao nosso banco de dados,
      ou seja, os <a href="http://addressforall.org/dados">Dados descritos</a> se podem ser acessados indiretamente atraves
      de <a href="http://git.addressforall.org">nossos repositorios <i>git</i></a>, como diretamente atraves das nossas APIs.
    </p>
<div style='text-align:center'><img src='resources/img/Reverse_proxy2.svg.png'></div>
  <p>Arquitetura e tecnologias utilizadas: atraves do NGINX as SQL Views e SQL functions expostas pelo PostgREST sao
    mantidas como <i>microservices</i> de acesso simples. A base de dados eh mantida em PostgreSQL v12+,
    na API-TEST a base DL03t_main, na API a base DL04s_main (<i>stable</i>).
  </p>
<div style="padding:1em">
<h2>
<a id="user-content-redirecionamentos" class="anchor" href="#redirecionamentos" aria-hidden="true"><svg class="octicon octicon-link" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"></path></svg></a>Redirecionamentos</h2>
<ul>
<li>
<p><code>tv.addressforall.org</code> esta funcionando, por hora redireciona apenas Youtube, mas <em>downloads</em> e outros  fornecedores de <em>streaming</em> podem ser utilizados.</p>
<ul>
<li>Canal <a href="http://tv.addressforall.org" rel="nofollow">http://tv.addressforall.org</a>
</li>
<li>Video específico,  <a href="http://tv.addressforall.org/MXzDtA48rdo" rel="nofollow">http://tv.addressforall.org/MXzDtA48rdo</a>
</li>
</ul>
</li>
<li>
<p><code>preserv.addressforall.org</code> esta funcionando no modo download, ou seja, permite fazer download a partir do nome completo do arquivo. Exemplos:</p>
<ul>
<li><a href="http://preserv.addressforall.org/download/058a6022054e8b3f9ba81f25f7511b58cbd4ad616b0510033b917f3f7f9f23d5.rar" rel="nofollow">preserv.addressforall.org/download/058a602*.rar</a></li>
<li><a href="http://preserv.addressforall.org/download/076312ec9decde9d854e0cd6913e3706703373500e129e39cd80c1b25dbead45.zip" rel="nofollow">preserv.addressforall.org/download/076312e*.zip</a></li>
<li><a href="http://preserv.addressforall.org/download/079c4057762797ae4e046e330e1053e1dcf3cbb411c617772be44049764b60f0.geojson" rel="nofollow">preserv.addressforall.org/download/079c405*.geojson</a></li>
<li><a href="http://preserv.addressforall.org/download/08074d0c4cf032ffbaf8f6c0596afd637ea5be38280d0b943d00eddec4451a88.kmz" rel="nofollow">preserv.addressforall.org/download/08074d0*.kmz</a></li>
<li><a href="http://preserv.addressforall.org/download/f0fd316ff8482ded50be8c537c48c17c6114c6844a6b76a0e99335a0288a60e7.pdf" rel="nofollow">preserv.addressforall.org/download/f0fd316*.pdf</a></li>
</ul>
</li>
<li>
<p><code>git.addressforall.org</code> esta funcionando. Exemplos:</p>
<ul>
<li>Geral <a href="http://git.addressforall.org" rel="nofollow">http://git.addressforall.org</a>
</li>
<li>Git específico,  <a href="http://git.addressforall.org/digital-preservation" rel="nofollow">http://git.addressforall.org/digital-preservation</a>
</li>
<li>Arquivo específico,  <a href="http://git.addressforall.org/digital-preservation-BR/blob/master/data/in/br-donor.csv" rel="nofollow">http://git.addressforall.org/digital-preservation-BR/blob/master/data/in/br-donor.csv</a>
</li>
<li>Git diferenciado,  <a href="http://git.addressforall.org/licenses" rel="nofollow">http://git.addressforall.org/licenses</a>
</li>
</ul>
</li>
<li>
<p><code>git-raw.addressforall.org</code> esta funcionando, permite o <em>download</em> direto de dados brutos. No exemplo acima, se queremos nao a pagina HTML do Github mas o arquivo <code>br-donor.csv</code>, basta remover o <code>/blob</code>, ou seja, sera simplesmente<br><a href="http://git-raw.addressforall.org/digital-preservation-BR/master/data/in/br-donor.csv" rel="nofollow">http://git-raw.addressforall.org/digital-preservation-BR/master/data/in/br-donor.csv</a></p>
</li>
</ul>
<h2>
<a id="user-content-api-teste" class="anchor" href="#api-teste" aria-hidden="true"><svg class="octicon octicon-link" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"></path></svg></a>API teste</h2>
<p>A base <em>testing</em>, <code>dl03t_main</code>, eh utilizada no dia a dia do desenvolvimento e manutencao.  Principais dispositivos ativos, falta o recheio com tabelas e funcoes.</p>
<p>APIs ja em uso, sintaxe <code>/v1{formatoSaida}/{modulo}/{funcao}/{parametros}</code>:</p>
<ul>
<li>
<p><a href="http://api-test.addressforall.org/v1/" rel="nofollow">http://api-test.addressforall.org/v1/</a> Bug (no futuro catalogo)</p>
</li>
<li>
<p><strong>Eclusa</strong>, exemplos.</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/eclusa/checkuserdir/peter" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/eclusa/checkuserdir/peter" rel="nofollow">http://api-test.addressforall.org/v1/eclusa/checkuserdir/peter</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/eclusa/checkuserfiles_step1/igor/0" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step1/igor/0" rel="nofollow">http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step1/igor/0</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/eclusa/checkuserfiles_step1/igor" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step1/igor" rel="nofollow">http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step1/igor</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/eclusa/checkuserfiles_step2/igor" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step2/igor" rel="nofollow">http://api-test.addressforall.org/v1/eclusa/checkuserfiles_step2/igor</a>
</li>
<li>...</li>
</ul>
</li>
<li>
<p><strong>Nav Eclusa</strong>, exclusivamente HTML, implementando certa navegabilidade pelas APIs da Eclusa. <br><a href="http://api-test.addressforall.org/v1.htm/nav_eclusa" rel="nofollow">http://api-test.addressforall.org/v1.htm/nav_eclusa</a></p>
</li>
<li>
<p>View Core, <strong>Jurisdiction</strong> item, exemplos:</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/BR-MG-BHE" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-MG-BHE" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-MG-BHE</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/BR-SP-SJC" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-SP-SJC" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-SP-SJC</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/BR-SP-SaoJoseCampos" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-SP-SaoJoseCampos" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/BR-SP-SaoJoseCampos</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/br;sp;sao.jose.campos" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/br;sp;sao.jose.campos" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/br;sp;sao.jose.campos</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/298019" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/298019" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/298019</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/br/3549904" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/br/3549904" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/br/3549904</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/76/3549904" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/76/3549904" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/76/3549904</a>
</li>
</ul>
</li>
<li>
<p>View Core, <strong>Jurisdiction</strong> listagem (completa ou com filtro), exemplos:</p>
<ul>
<li>full paginada (<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction?limit=100&amp;offset=34" rel="nofollow">htm</a>)    <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction?limit=100&amp;offset=34" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction?limit=100&amp;offset=34</a>
</li>
<li>free (<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/isolabel_ext.lk.BR-SP-Ad" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/isolabel_ext.lk.BR-SP-Ad" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/isolabel_ext.lk.BR-SP-Ad</a>
</li>
<li>second level (<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/parent_abbrev.lk.BR" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/parent_abbrev.lk.BR" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/parent_abbrev.lk.BR</a>
</li>
<li>free (<a href="http://api-test.addressforall.org/v1.htm/vw_core/jurisdiction/parent_abbrev.eq.INT" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/jurisdiction/parent_abbrev.eq.INT" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/jurisdiction/parent_abbrev.eq.INT</a>
</li>
</ul>
</li>
<li>
<p>View Core, <strong>Donor</strong> item, exemplos:</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/1" rel="nofollow">htm</a>)  <a href="http://api-test.addressforall.org/v1/vw_core/donor/1" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/1</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/IBGE" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/IBGE" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/IBGE</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/cnpj:33787094000140" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/cnpj:33787094000140" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/cnpj:33787094000140</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/Q268072" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/Q268072" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/Q268072</a>
</li>
</ul>
</li>
<li>
<p>View Core, <strong>Donor</strong> listagem (completa ou com filtro), exemplos:</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/scope.lk.BR-SP" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/scope.lk.BR-SP" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/scope.lk.BR-SP</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/legalname.lk.Prefeitura+Municipal+DE+V" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/legalname.lk.Prefeitura+Municipal+DE+V" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/legalname.lk.Prefeitura+Municipal+DE+V</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/legalname.lk.Vila" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/legalname.lk.Vila" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/legalname.lk.Vila</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/url~SC.gov" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/url~SC.gov" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/url~SC.gov</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/donor/shortname~SP-S" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/donor/shortname~SP-S" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/donor/shortname~SP-S</a>
</li>
</ul>
</li>
<li>
<p><strong>Nav Core Donor</strong>, exclusivamente HTML, implementando certa navegabilidade pelas APIs da Eclusa. <br><a href="http://api-test.addressforall.org/v1.htm/nav_core/donor" rel="nofollow">http://api-test.addressforall.org/v1.htm/nav_core/donor</a></p>
</li>
<li>
<p>View Core, <strong>Origin</strong> listagem (completa ou com filtro), exemplos:</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/jurisd_state.eq.SP" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/jurisd_state.eq.SP" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/jurisd_state.eq.SP</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/jurisd_isolabel_ext.eq.BR-SP-Itu" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/jurisd_isolabel_ext.eq.BR-SP-Itu" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/jurisd_isolabel_ext.eq.BR-SP-Itu</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/donor_id.eq.24" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/donor_id.eq.24" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/donor_id.eq.24</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/donor_shortname.eq.SP-ITU" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/donor_shortname.eq.SP-ITU" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/donor_shortname.eq.SP-ITU</a>
</li>
</ul>
</li>
<li>
<p>View Core, <strong>Origin</strong> item, exemplos:</p>
<ul>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/sha256:c35e3b28" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/sha256:c35e3b28" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/sha256:c35e3b28</a>
</li>
<li>(<a href="http://api-test.addressforall.org/v1.htm/vw_core/origin/5524" rel="nofollow">htm</a>) <a href="http://api-test.addressforall.org/v1/vw_core/origin/5524" rel="nofollow">http://api-test.addressforall.org/v1/vw_core/origin/5524</a>
</li>
</ul>
</li>
<li>
<p><strong>Nav Core Origin</strong>, exclusivamente HTML, implementando certa navegabilidade pelas APIs da Eclusa. <br><a href="http://api-test.addressforall.org/v1.htm/nav_core/origin" rel="nofollow">http://api-test.addressforall.org/v1.htm/nav_core/origin</a></p>
</li>
</ul>
<p>API geral de consulta aa base ou seu catalogo:</p>
<ul>
<li>
<a href="http://api-test.addressforall.org" rel="nofollow">http://api-test.addressforall.org</a> no futuro vai listar os nomes do primeiro nivel e indicar como solicitar help dos demais</li>
<li>
<a href="http://api-test.addressforall.org/_sql" rel="nofollow">http://api-test.addressforall.org/_sql</a> ou <a href="http://api-test.addressforall.org/_sql.json" rel="nofollow">http://api-test.addressforall.org/_sql.json</a> , catalogo geral em JSON</li>
<li>
<a href="http://api-test.addressforall.org/_sql.csv" rel="nofollow">http://api-test.addressforall.org/_sql.csv</a> , catalogo geral em CSV</li>
<li>
<code>http://api-test.addressforall.org/_sql/{query}</code> Roda query SQL de tabela valida (conforme catalogo geral). Por exemplo <a href="http://api-test.addressforall.org/_sql/donor?select=id,legalname,url&amp;limit=10" rel="nofollow">http://api-test.addressforall.org/_sql/donor?select=id,legalname,url&amp;limit=10</a>
</li>
<li>
<code>http://api-test.addressforall.org/_sql.csv/{query}</code> mesmo que <code>/_sql/{query}</code> porem retornando formato CSV.</li>
</ul>
<p>Exemplo de query:</p>
<ul>
<li>html <a href="http://api-test.addressforall.org/v1.html/eclusa/checkuserdir/peter?select=username,pack_path" rel="nofollow">http://api-test.addressforall.org/v1.html/eclusa/checkuserdir/peter?select=username,pack_path</a>
</li>
<li>json <a href="http://api-test.addressforall.org/v1.json/eclusa/checkuserdir/peter?select=username,pack_path" rel="nofollow">http://api-test.addressforall.org/v1.json/eclusa/checkuserdir/peter?select=username,pack_path</a>
</li>
</ul>
<h2>
<a id="user-content-api-estavel" class="anchor" href="#api-estavel" aria-hidden="true"><svg class="octicon octicon-link" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"></path></svg></a>API estavel</h2>
<p>Por hora apenas amostra em  <a href="http://api.addressforall.org/_sql/" rel="nofollow">http://api.addressforall.org/_sql/</a></p>
<p>Assim que a base DL03 estiver consolidada poderemos promovela-la a DL04.</p>

</div>

</section>
