const fs = require("fs");
const _d = require("./init-data.js");
const turf = require("@turf/turf");

const nd = JSON.parse(fs.readFileSync(_d.Bogota.ND));
const scat = JSON.parse(fs.readFileSync(_d.Bogota.SCAT));

turf.featureEach(nd, function (currentPoint, index) {
  let point = currentPoint;
  for (var i = 0; i < scat.features.length; i++) {
    let polygon = scat.features[i];
    if (turf.booleanPointInPolygon(point.geometry, polygon.geometry)) {
      point.properties["SCANOMBRE"] = polygon.properties.SCANOMBRE;
      // console.log(point.properties);
      console.log(nd.features.length + "-" + index);
      break;
    }
  }
});

fs.writeFileSync(
  _d.Output + _d.yyyymmdd + "_nd_sector_catastral_Bogota.geojson",
  JSON.stringify(nd),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);
