<section class="main" id="dados">
    <h1>API</h1>
    <p>
      Las APIs del portal del Instituto AddressForAll corresponden a funcionalidades de acceso directo a nuestra base de datos, es decir,
      los <a href="http://addressforall.org/dados">Datos descritos</a> se puede acceder tanto de forma bruta a través de
      <a href="http://git.addressforall.org">nuestros repositorios <i>git</i></a>, como personalizada a través de nuestras API.
    </p>
<div style='text-align:center'><img src='resources/img/Reverse_proxy2.svg.png'></div>
  <p>Arquitectura y tecnologías utilizadas: a través de NGINX las Vistas SQL y las funciones SQL expuestas por PostgREST
   se mantienen como <i>microservicios</i> de simple acceso. La base de datos se mantiene en PostgreSQL v12+, en API-TEST la base DL03t_main,
   en la API la base DL04s_main (estable).
  </p>
<div style="padding:1em">
<h2>
<a id="user-content-redirecionamentos" class="anchor" href="#redirecionamentos" aria-hidden="true"><svg class="octicon octicon-link" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M7.775 3.275a.75.75 0 001.06 1.06l1.25-1.25a2 2 0 112.83 2.83l-2.5 2.5a2 2 0 01-2.83 0 .75.75 0 00-1.06 1.06 3.5 3.5 0 004.95 0l2.5-2.5a3.5 3.5 0 00-4.95-4.95l-1.25 1.25zm-4.69 9.64a2 2 0 010-2.83l2.5-2.5a2 2 0 012.83 0 .75.75 0 001.06-1.06 3.5 3.5 0 00-4.95 0l-2.5 2.5a3.5 3.5 0 004.95 4.95l1.25-1.25a.75.75 0 00-1.06-1.06l-1.25 1.25a2 2 0 01-2.83 0z"></path></svg></a>API de busca</h2>
<p>Ver  documentacion en <a href="https://git.AddressForAll.org/WS-CO/tree/main/doc#readme">git.AddressForAll.org/WS-CO</a>.
</section>
