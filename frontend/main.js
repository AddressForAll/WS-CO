import API, {
  mapCenter,
  olKey as key,
  markerBlue,
  markerOrange,
} from "./addressforall.js";
import "./style.css";
import "ol/ol.css";
import Map from "ol/Map";
import View from "ol/View";
import { Tile as TileLayer, Vector as VectorLayer } from "ol/layer";
import { XYZ as XYZ, Vector as VectorSource } from "ol/source";
import { Attribution, defaults as defaultControls } from "ol/control";
import { Icon, Style } from "ol/style";
import GeoJSON from "ol/format/GeoJSON";

// import { useGeographic } from "ol/proj";
// useGeographic();

import $ from "jquery";
import mark from "mark.js/dist/jquery.mark.js";
import { clearAllProjections } from "ol/proj";
window.jQuery = window.$ = $;

const attribution = new Attribution({
  collapsible: false,
});

const icon = new Style({
  image: new Icon({
    anchor: [0.5, 31],
    anchorXUnits: "fraction",
    anchorYUnits: "pixels",
    src: markerBlue,
  }),
  // text: new Text({
  //   text: getText,
  //   font: "11px",
  //   fill: new Fill({ color: "rgba(52, 102, 180, 1)" }),
  //   stroke: new Stroke({ color: "rgba(46, 44, 42, 0.5)", width: .5 }),
  //   textAlign: "center",
  //   offsetY: -20,
  // }),
});

const selectedIcon = new Style({
  image: new Icon({
    anchor: [0.5, 31],
    anchorXUnits: "fraction",
    anchorYUnits: "pixels",
    src: markerOrange,
  }),
  // text: new Text({
  //   text: getText,
  //   font: "11px",
  //   fill: new Fill({ color: "rgba(52, 102, 180, 1)" }),
  //   stroke: new Stroke({ color: "rgba(46, 44, 42, 0.5)", width: .5 }),
  //   textAlign: "center",
  //   offsetY: -20,
  // }),
});

// const scaleBar = new ScaleLine({
//   units: "metric",
//   bar: true,
//   steps: 4,
//   text: true,
//   minWidth: 140,
// });

const baseMap = new TileLayer({
  source: new XYZ({
    attributions:
      '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> ' +
      '© <a href="https://www.openstreetmap.org/copyright">' +
      "OpenStreetMap contributors</a>",
    url:
      "https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=" +
      key,
  }),
});

const addresses = new VectorLayer({
  style: icon,
});

const map = new Map({
  controls: defaultControls({ attribution: false }).extend([attribution]),
  target: "map",
  layers: [baseMap, addresses],
  view: new View({
    projection: "EPSG:4326",
    center: mapCenter,
    zoom: 15,
  }),
});

// map.addControl(scaleBar);

const searchBounded = (term, boundingBox) => {
  $.ajax({
    url: API.search_bounded,
    type: "POST",
    processData: false,
    contentType: "application/json",
    cache: true,
    jsonp: false,
    data: JSON.stringify({
      _q: term,
      viewbox: boundingBox,
      lim: 1000,
    }),
    dataType: "json",
    crossDomain: true,
    success: function (data) {
      if (data.features) {
        // clear map
        addresses.setSource(null);
        // plot search results
        addresses.setSource(
          new VectorSource({
            features: new GeoJSON().readFeatures(data),
          })
        );
        let result = data.features.map(
          (feature) =>
            '<li id="' +
            feature.properties._id +
            '" class="feature list-group-item d-flex justify-content-between align-items-start"  data-coordinates="' +
            JSON.stringify(feature.geometry.coordinates) +
            '">' +
            '<div class="ms-2 me-auto">' +
            '<div class="address fw-bold">' +
            feature.properties.address +
            "</div>" +
            '<div class="display_name fw-lighter">' +
            feature.properties.display_name +
            " " +
            feature.properties.barrio +
            // " " +
            // feature.properties.comuna +
            "</div>" +
            "</div>" +
            '<span class="badge bg-info bg-opacity-85 rounded-pill">' +
            Math.round(feature.properties.similarity * 100) +
            "%" +
            "</span>" +
            "</li>"
        );
        // show results
        $("#search").removeClass("is-invalid");
        $("#afo-results").show();
        $("#clear-btn").show();
        $("#afo-results").children("ul").empty().show();
        // populate the list
        $("#afo-results").children("ul").append(result);
        // highlight matching words
        $(".display_name").mark(term.split(" "));
      } else {
        $("#search").addClass("is-invalid");
        clearResults();
      }
    },
  });
};

const search = (e) => {
  let searchBox = $(e.target);
  e.stopPropagation();
  clearTimeout(searchBox.data("timeout"));
  searchBox.data(
    "timeout",
    setTimeout(function () {
      let term = searchBox.val();
      if (term.length >= 3) {
        searchBounded(term, map.getView().calculateExtent(map.getSize()));
      }
    }, 200)
  );
};

$("#search").on("keyup", function (e) {
  search(e);
});

$(document).on("keydown", "form", function (event) {
  return event.key != "Enter";
});

$(document).on("click", "#clear-btn", function (e) {
  e.stopPropagation();
  e.stopImmediatePropagation();
  clearResults();
  $("#search").val("");
  map.getView().setZoom(15);
  $(e.currentTarget).hide();
  return false;
});

$(document).on("click", ".feature", function (e) {
  e.stopPropagation();
  e.stopImmediatePropagation();
	let currentItem = $(e.currentTarget);
	let view = map.getView();
  let coordinates = JSON.parse(currentItem.attr("data-coordinates"));
  let selectedFeature = addresses
    .getSource()
    .getClosestFeatureToCoordinate(coordinates);
  selectedFeature.setStyle(selectedIcon);
  view.setCenter(coordinates);
  view.setZoom(20);
  currentItem.addClass("selected");
});

const clearResults = () => {
  addresses.setSource(null);
  $("#afo-results").children("ul").empty().hide();
};
