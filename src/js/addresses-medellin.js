const fs = require("fs");
const _d = require("./init-data.js");
const converter = require("json-2-csv");

const nd = JSON.parse(fs.readFileSync(_d.Medellin.NDCP));
const viasMedellin = JSON.parse(fs.readFileSync(_d.Medellin.Vias));
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

const ndTable = [];
console.log(nd.features.length);
for (var i = 0; i < nd.features.length; i++) {
// for (var i = 0; i < 10; i++) {
  let feature = nd.features[i];
  let properties = feature.properties;
  ndTable.push({
    id: properties.OBJECTID,
    lon: feature.geometry.coordinates[0],
    lat: feature.geometry.coordinates[1],
    number: properties.PLACA,
    street: properties.VIA,
    city: "Medellin",
    district: null,
    region: "ANT",
    postcode: properties.CODIGO_POS,
    hash: null,
    // --------------------------------
    cbml: properties.CBML,
    tipo_via: properties.TIPO_VIA,
    tipo_cruce: properties.TIPO_CRUCE,
    codigo_man: properties.CODIGO_MAN,
    codigo_bar: properties.CODIGO_BAR,
    nombre_bar: properties.NOMBRE_BAR,
    codigo_com: properties.CODIGO_COM,
    nombre_com: properties.NOMBRE_COM,
    // --------------------------------
    via_name: viasMedellin[properties.VIA] || null,
    address: properties.VIA + " #" + properties.PLACA,
    display_name: displayNAme(properties.VIA, properties.PLACA, properties.NOMBRE_BAR),
    // housename: '',
    // divipola: '',
  });
}
// console.log(ndTable);
converter.json2csv(JSON.parse(JSON.stringify(ndTable)), function (err, csv) {
  fs.writeFileSync(_d.Output + _d.yyyymmdd + "_Medellin.csv", csv);
});
