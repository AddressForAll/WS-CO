const fs = require("fs");
const _d = require("./init-data.js");

const nv = JSON.parse(fs.readFileSync(_d.Medellin.NV));

const stripLabel = (label) => {
  return label ? label.split(" #")[0] : "";
};

let viaNames = nv.features
  .map((a) => [
    a.properties.TIPO_VIA,
    stripLabel(a.properties.LABEL),
    a.properties.NOMBRE_COM,
  ])
  .filter((a) => a[2] !== null && a[1] !== a[2]);

// console.log(new Set(viaNames.map((a) => a[0])));
// Set(7) { 'CR', 'CL', 'TV', 'DG', 'CQ', 'SR', 'VR' } 
 
let uniqueNames = [
  ...new Set(
    viaNames.map(
      (a) =>
        a.join('|')
    )
  ),
].map((a) => a.split('|'));
// console.log(uniqueNames);

const buildObject = (arr) => {
  const obj = {};
  for (let i = 0; i < arr.length; i++) {
    obj[arr[i][1]] = arr[i][2];
  }
  return obj;
};

console.log(buildObject(uniqueNames));

fs.writeFile(
  _d.Output + _d.yyyymmdd + "_vias_medellin.json",
  JSON.stringify(buildObject(uniqueNames), null, 2),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);