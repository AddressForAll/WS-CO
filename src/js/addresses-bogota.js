const fs = require("fs");
const _d = require("./init-data.js");
const converter = require("json-2-csv");

const nd = JSON.parse(fs.readFileSync(_d.Bogota.NDCP));
const viasBogota = JSON.parse(fs.readFileSync(_d.Bogota.Vias));
const scan = JSON.parse(fs.readFileSync(_d.Bogota.SCAN));

// console.log(nd)

// const ptsWithOutVIA = nd.features.filter((a) => a.properties.VIA === null);
// console.table(ptsWithOutVIA);

// const ptsWithOutPostcode = nd.features.filter(
//   (a) => a.properties.CODIGO_POS === null
// );
// console.table(ptsWithOutPostcode);
const displayNAme = (via, placa, barrio) => {
  let chunks = via.split(" ");
  return _d.TipoDeVia[chunks[0]] + " " + chunks[1] + " " + placa + " " + barrio;
};

const viaName = (via) => {
  let viaName = viasBogota[via]
    ? (viasBogota[via].cur_name || "") +
      "|" +
      (viasBogota[via].alt_name || "") +
      "|" +
      (viasBogota[via].ant_name || "")
    : null;
  return viaName;
};
// console.log(nd.features[1])
const parts = 3;
const amnt = Math.round(nd.features.length / parts) + 1;
// const amnt = 500000;
const j = 2;
// for (var j = 0; j < parts; j++) {
  let ndTable = [];
  // console.log(nd.features.length);
  for (var i = j * amnt; i < (j + 1) * amnt && i < nd.features.length; i++) {
    // for (var i = 0; i < 1000; i++) {
    let feature = nd.features[i];
    let properties = feature.properties;
    // console.log(properties)
    if (properties.PDONVIAL !== null) {
      let scanombre =
        scan[
        "" + feature.geometry.coordinates[0] + feature.geometry.coordinates[1]
        ];
      ndTable.push({
        id: properties.PDOCODIGO,
        lon: feature.geometry.coordinates[0],
        lat: feature.geometry.coordinates[1],
        number: properties.PDOTEXTO,
        street: properties.PDONVIAL,
        city: "Bogota",
        district: null,
        region: "DC",
        postcode: properties.CODIGO_POS + "-" + properties.SECUENCIA,
        hash: null,
        // --------------------------------
        // cbml: properties.CBML,
        // tipo_via: properties.TIPO_VIA,
        // tipo_cruce: properties.TIPO_CRUCE,
        // codigo_man: properties.CODIGO_MAN,
        // codigo_bar: properties.CODIGO_BAR,
        nombre_bar: scanombre,
        // codigo_com: properties.CODIGO_COM,
        // nombre_com: properties.NOMBRE_COM,
        // --------------------------------
        via_name: viaName(properties.PDONVIAL),
        address: properties.PDONVIAL + " #" + properties.PDOTEXTO,
        display_name: displayNAme(
          properties.PDONVIAL,
          properties.PDOTEXTO,
          scanombre
        ),
        // housename: '',
        // divipola: '',
      });
    }
    console.log(nd.features.length + "-" + i);
  }
  // console.table(ndTable);
  converter.json2csv(JSON.parse(JSON.stringify(ndTable)), function (err, csv) {
    fs.writeFileSync(_d.Output + _d.yyyymmdd + "_Bogota_S0" + j + ".csv", csv);
  });
// };
