const fs = require("fs");
const _d = require("./init-data.js");
const turf = require("@turf/turf");

const nd = JSON.parse(fs.readFileSync(_d.Bogota.ND));
const cp = JSON.parse(fs.readFileSync(_d.Bogota.CP));

turf.featureEach(nd, function (currentPoint) {
  let point = currentPoint;
  for (var i = 0; i < cp.features.length; i++) {
    let polygon = cp.features[i];
    if (turf.booleanPointInPolygon(point.geometry, polygon.geometry)) {
      point.properties["CODIGO_POS"] = polygon.properties.CodigoPost;
      point.properties["SECUENCIA"] = polygon.properties.Secuencia;
      // console.log(point.properties);
      break;
    }
  }
});

fs.writeFileSync(
  _d.Output + _d.yyyymmdd + "_nd_postalcode_bogota.geojson",
  JSON.stringify(nd),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);
