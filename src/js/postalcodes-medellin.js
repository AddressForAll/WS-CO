const fs = require("fs");
const _d = require("./init-data.js");
const turf = require("@turf/turf");

const nd = JSON.parse(fs.readFileSync(_d.Medellin.ND));
const cp = JSON.parse(fs.readFileSync(_d.Medellin.CP));

turf.featureEach(nd, function (currentPoint) {
  let point = currentPoint;
  for (var i = 0; i < cp.features.length; i++) {
    let polygon = cp.features[i];
    if 
      (turf.booleanPointInPolygon(point.geometry, polygon.geometry)) {
      point.properties["CODIGO_POS"] = polygon.properties.CODIGO_POS;
      // console.log(point.properties);
      break;
    };
  };
});

fs.writeFileSync(
  _d.Output + _d.yyyymmdd +"_nd_postalcode.geojson",
  JSON.stringify(nd),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);