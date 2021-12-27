const fs = require("fs");
const _d = require("./init-data.js");

// const ndcp = JSON.parse(fs.readFileSync(_d.Bogota.NDCP));
const ndscat = JSON.parse(fs.readFileSync(_d.Bogota.NDSCAT));

const buildObject = (arr) => {
  const obj = {};
  for (let i = 0; i < arr.length; i++) {
    let key =
      "" + arr[i].geometry.coordinates[0] + arr[i].geometry.coordinates[1];
    obj[key] = arr[i].properties.SCANOMBRE;
  }
  return obj;
};

const scanombres = buildObject(ndscat.features);

// for (var i = 0; i < ndcp.features.length; i++) {
//   let key =
//     "" +
//     ndcp.features[i].geometry.coordinates[0] +
//     ndcp.features[i].geometry.coordinates[0];
//   ndcp.features[i].properties.SCANOMBRE = scanombres[key];
//   // console.log(ndcp.features[i]);
//   // console.log(ndcp.features.length + "-" + i);
// };

fs.writeFileSync(
  _d.Output + _d.yyyymmdd + "_scanombres_bogota.geojson",
  JSON.stringify(scanombres),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);
