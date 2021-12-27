const fs = require("fs");
const _d = require("./init-data.js");

const nv = JSON.parse(fs.readFileSync(_d.Bogota.NV));

// const stripLabel = (label) => {
//   return label ? label.split(" #")[0] : "";
// };

let viaNames = nv.features
  .map((a) => [
    a.properties.MVITIPO,
    a.properties.MVIETIQUET,
    // stripLabel(a.properties.LABEL),
    a.properties.NAME,
    a.properties.MVINOMBRE,
    a.properties.MVINALTERN,
    a.properties.MVINANTIGU,
  ])
  .filter((a) => a[1] !== null);

// console.table(viaNames);

// console.log(new Set(viaNames.map((a) => a[0])));
// Set(6) { 'KR', 'CL', 'TV', 'AK', 'AC', 'DG' }

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
    obj[arr[i][1]] = {
      name: (arr[i][2]),
      cur_name: arr[i][3],
      alt_name: arr[i][4],
      ant_name: arr[i][5],
    };
  }
  return obj;
};

// console.log(buildObject(uniqueNames));

fs.writeFile(
  _d.Output + _d.yyyymmdd + "_vias_bogota.json",
  JSON.stringify(buildObject(uniqueNames), null, 2),
  (err) => {
    if (err) {
      throw err;
    }
    console.log("Done!");
  }
);
