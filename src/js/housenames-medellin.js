const fs = require("fs");
const _d = require("./init-data.js");
const turf = require("@turf/turf");

// const nd = JSON.parse(fs.readFileSync(_d.NDPostalcode));
const lp = JSON.parse(fs.readFileSync(_d.Medellin.LP));
const pi = JSON.parse(fs.readFileSync(_d.Medellin.PI));

// turf.featureEach(nd, function (currentPoint) {
//   let point = currentPoint;
//   for (var i = 0; i < cp.features.length; i++) {
//     let polygon = cp.features[i];
//     if (turf.booleanPointInPolygon(point.geometry, polygon.geometry)) {
//       point.properties["CODIGO_POS"] = polygon.properties.CODIGO_POS;
//       // console.log(point.properties);
//       break;
//     }
//   }
// });

// fs.writeFile(
//   _d.Output + _d.yyyymmdd + "_nd_postalcode_housename.geojson",
//   JSON.stringify(nd),
//   (err) => {
//     if (err) {
//       throw err;
//     }
//     console.log("Done!");
//   }
// );