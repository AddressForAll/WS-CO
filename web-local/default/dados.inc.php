<section class="main" id="data">
  <div>
    <h1>Datos</h1>
    <p>
       En el contexto de país (Colombia, Brasil, etc.), los datos puestos a disposición por el Instituto AddressForAll
        pueden ser descargados por municipio (datos locales) o a nivel nacional. Comprenda el proceso de tratamiento y cómo
       estos datos se almacenan y se ponen a disposición.
    </p>

<hr/>

    <h2>Repositorios de datos y flujo general</h2>
    <p>
       El Instituto recibe datos donados por varias fuentes, como ayuntamientos, IGAC y OpenStreetMap,
       que publican o transfieren bajo una licencia abierta (CC0, ODbL o de otro tipo) los datos que producen.
    </p>

    <div style='text-align:center'><img src='resources/img/datafigs-flow1.svg'></div>


<h2>Preservación digital</h2>
<p>El micrositio donde esté el listyado de fuentes de datos de Colombia es <a href="https://git.digital-guard.org/preserv-CO">git.digital-guard.org/preserv-CO</a>. 
En él se describen los datos en bruto, con sus fuentes, licencias y prueba de integridad. Resumen y <b>descarga</b>:
</p>

<ul>
<li><a href="https://github.com/digital-guard/preserv-CO/blob/main/data/ANT/Medellin/_pk002/make_conf.yaml">CO ANT/Medellin/_pk002</a>
 <ul dir="auto">
 <li><a href="http://dl.digital-guard.org/410d02a87e8d2955849ba644ed8830f3d6761b31f4d0dbf044d39975ffc02be1.zip" rel="nofollow"><strong>Malla Vial</strong> (<code>410d02a</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/2630981b3e7c796f23a938d8c727ed47cf890547336ead89738b96e67fe62e7a.zip" rel="nofollow"><strong>Nomenclatura Domiciliaria</strong> (<code>2630981</code>)</a></li>
 </ul>
</li>

<li><a href="https://github.com/digital-guard/preserv-CO/blob/main/data/DC/Bogota/_pk001/make_conf.yaml">CO DC/Bogota/_pk001</a>
 <ul dir="auto">
 <li><a href="http://dl.digital-guard.org/fff3ae00d851d47c02d3b510d856526693a47250b4739b57cc6eaa88e0f57acd.zip" rel="nofollow"><strong>Lotes</strong> (<code>fff3ae0</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/befe4d8cbbd51162e70f4f3dc4065acc430e20f2161073fabd007c575cd72098.zip" rel="nofollow"><strong>Malla Vial</strong> (<code>befe4d8</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/8585490fefe89ff086a9234b27232cda9e29df9ad0b63d19acbd43f3760d04b5.zip" rel="nofollow"><strong>Ponto de Endereço</strong> (<code>8585490</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/ed072b0391d6c4a9bd76237b4ebb55de4f00ff0b73325d715d35baf29f41278e.zip" rel="nofollow"><strong>Quadras</strong> (<code>ed072b0</code>)</a></li>
 </ul>
</li>

<li><a href="https://github.com/digital-guard/preserv-CO/blob/main/data/_pk003/make_conf.yaml">CO _pk003</a>
 <ul dir="auto">
 <li><a href="http://dl.digital-guard.org/d49ab53b06be4934f160bee3a92d671346d9ad2137fbd901e99875ab2fad7621.zip" rel="nofollow"><strong>Manzana</strong> (<code>d49ab53</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/2db40c6a0a4ddc0bb0f765a9195c34b258de49b179f90cd54244406e0c62df83.zip" rel="nofollow"><strong>Nomenclatura Domiciliaria urbano e rural</strong> (<code>2db40c6</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/6f35dbfe7ad230f1f6f2209f5d50901c05965d7b97a9c3dafada4a9af012c335.zip" rel="nofollow"><strong>Nomenclatura Vial urbano e rural</strong> (<code>6f35dbf</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/137dc416e70776ac57c37a4fb0cb9bedb1468e91ed73eaa656ddee91011daed7.zip" rel="nofollow"><strong>Terreno urbano e rural</strong> (<code>137dc41</code>)</a></li>
 <li><a href="http://dl.digital-guard.org/08bc4f124ca0a65d9eae97663eca0894d3bb4d37ead1168b767a540b68db324f.zip" rel="nofollow"><strong>Vereda</strong> (<code>08bc4f1</code>)</a></li>
 </ul>
</li>

<li><a href="https://github.com/digital-guard/preserv-CO/blob/main/data/_pk004/make_conf.yaml">CO _pk004</a>
 <ul dir="auto">
 <li><a href="http://dl.digital-guard.org/b82a7ab85d2cb4342d51b7ab97e74be291a57c9f35001bf827d1226527449ca2.pbf" rel="nofollow"><strong>Dados OpenStreetMap</strong> (<code>b82a7ab</code>)</a>
     &nbsp; <a target="_showlayer" href="https://github.com/digital-guard/preservCutGeo-CO2021/tree/main/data/_pk004" title="haga clic aquí para ver los puntos de Geoaddress"><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-geoaddress.png" align="middle" width="40" style="max-width: 100%;"></a>
 </li>
 </ul>
</li>

</ul>

<p>El <a href="https://es.wikipedia.org/wiki/Suma_de_verificaci%C3%B3n"><i>hash</i> de integridad</a> del archivo (predeterminado SHA256) es el nombre del archivo, también expresado entre paréntesis sus primeros 7 dígitos.</p>

<p>Los descriptores (metadatos) son archivos <a href="https://en.wikipedia.org/wiki/YAML">formato YAML</a> (JSON-intercambiable)
están relacionados con el paquete de datos (<i>package</i>) donado, resaltados arriba como _pk001, _pk002, etc. Siguen las convenciones documentadas en:
<a href="http://git.digital-guard.org/preserv/blob/main/docs/pt/ftypes.md">git.digital-guard.org/preserv/blob/main/docs</a>. Resumen:


<style>
ul.imgPad li {margin: 10pt 0;}
</style>
<ul class="imgPad" style="list-style-type:none">
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-geoaddress.png" align="middle" width="40" style="max-width: 100%;">  <strong>geoaddress</strong>: Geo-endereço. Representação geográfica do endereço, como ponto.</li>
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-via.png" align="middle" width="40" style="max-width: 100%;"> <strong>via</strong>: Eixo de via. Logradouro representado por linha central, com nome oficial e codlog opcional.</li>
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-genericVia.png" align="middle" width="40" style="max-width: 100%;"> <strong>genericvia</strong>: Ferrovia, hidrovia ou qualquer outra "via complementar generalizada" que ajude a delimitar polígonos de quadra. </li>
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-building.png" align="middle" width="40" style="max-width: 100%;"> <strong>building</strong>: Polígono de edificação.</li>
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-parcel.png" align="middle" width="40" style="max-width: 100%;"> <strong>parcel</strong>: Polígono de lote.</li>
<li><img src="https://github.com/digital-guard/preserv/raw/main/docs/assets/layerIcon-namedZone.png" align="middle" width="40" style="max-width: 100%;"> <strong>nsvia</strong>: <em>Namespace</em> para distinguir vias duplicadas, tipicamente nome de polígono de bairro ou de loteamento.</li>
<li><strong>block</strong>: Quadras ou divisões poligonais similares.</li>
</ul>

  </div>
</section>
