const olKey =
  "pk.eyJ1IjoiZWxwYmF0aXN0YSIsImEiOiJja3gyZHl5OXYxbm5yMnFxOTFtZWhqbWlhIn0.bbHJjnHrt_d9iqu4hBZgyw";
const markerBlue = "../img/map-marker-blue-32.png";
const markerOrange = "../img/map-marker-orange-32.png";
const mapCenter = [-75.595483, 6.269356];

const APIURL = "http://api.addressforall.org/test/_sql/rpc/";
const API = {
  search: APIURL + "search",
  search_bounded: APIURL + "search_bounded",
};

export default API;
export { olKey, mapCenter, markerBlue, markerOrange };

// http://api.addressforall.org/test/get_centroid?