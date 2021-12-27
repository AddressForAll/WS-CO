# Preparación y Limpieza de Datos <!-- omit in toc -->

- [1. Medellín](#1-medellín)
  - [1.1. Datos Utilizados](#11-datos-utilizados)
  - [1.2. Procesamiento](#12-procesamiento)
- [2. Bogotá](#2-bogotá)
  - [2.1. Datos Utilizados](#21-datos-utilizados)
  - [2.2. Procesamiento](#22-procesamiento)
- [3. Colombia Restante](#3-colombia-restante)
- [4. Anexos y Anotaciones](#4-anexos-y-anotaciones)
  - [4.1. Datos procesados](#41-datos-procesados)
  - [4.2. Abreviaturas](#42-abreviaturas)
- [5. Referencias](#5-referencias)

## 1. Medellín

### 1.1. Datos Utilizados

[Alcaldía de Medellín OpenData](https://geomedellin-m-medellin.opendata.arcgis.com)

![Mapa de Medellín](img/Medellin.png)

1. [Nomenclatura Domiciliaria](https://geomedellin-m-medellin.opendata.arcgis.com/datasets/nomenclatura-domiciliaria)
2. [Nomenclatura Vial](https://geomedellin-m-medellin.opendata.arcgis.com/datasets/nomenclatura-vial)
3. [Código Postal](https://geomedellin-m-medellin.opendata.arcgis.com/datasets/codigo-postal)
4. [Lote del Predio](https://geomedellin-m-medellin.opendata.arcgis.com/datasets/lote-del-predio)
5. [Puntos de Interés o Nombre del Predio](https://geomedellin-m-medellin.opendata.arcgis.com/datasets/puntos-de-interes-o-nombre-del-predio)

### 1.2. Procesamiento

478,098 direcciones potenciales

## 2. Bogotá

### 2.1. Datos Utilizados

[Datos Abiertos Bogotá](https://datosabiertos.bogota.gov.co)

![Mapa de Bogotá](img/Bogota.png)

1. [Placa Domiciliaria. Bogotá D.C.](https://datosabiertos.bogota.gov.co/dataset/placa-domiciliaria)
2. [Maya Vial Integral. Bogotá D.C.](https://datosabiertos.bogota.gov.co/dataset/malla-vial-integral-bogota-d-c1)
3. [Código Postal Ampliado. Bogotá D.C.](https://datosabiertos.bogota.gov.co/dataset/codigo-postal-ampliado-bogota-d-c)
4. [Sector Catastral. Bogotá D.C.](https://datosabiertos.bogota.gov.co/dataset/sector-catastral)

### 2.2. Procesamiento

1,794,693 direcciones potenciales

## 3. Colombia Restante

## 4. Anexos y Anotaciones

### 4.1. Datos procesados

```javascript
Medellin = {
  ND: "Data/Medellin/geojson/nomenclatura_domiciliaria.geojson",
  NV: "Data/Medellin/geojson/nomenclatura_vial.geojson",
  CP: "Data/Medellin/geojson/codigo_postal.geojson",
  PI: "Data/Medellin/geojson/puntos_de_interes_o_nombre_del_predio.geojson",
  LP: "Data/Medellin/geojson/lote_del_predio.geojson",
  Vias: "Output/20211220_vias_medellin.json",
  NDCP: "Output/20211221_nd_postalcode_medellin.geojson",
};
Bogota = {
  ND: "Data/Bogota/geojson/placa_domiciliaria.geojson",
  NV: "Data/Bogota/geojson/malla_vial_integral.geojson",
  CP: "Data/Bogota/geojson/codigo_postal.geojson",
  SCAT: "Data/Bogota/geojson/scat.geojson",
  Vias: "Output/20211221_vias_bogota.json",
  NDCP: "Output/20211221_nd_postalcode_bogota.geojson",
  NDSCAT: "Output/20211221_nd_sector_catastral_bogota.geojson",
  SCAN: "Output/20211221_scanombres_bogota.geojson",
};
Colombia = {};
```

### 4.2. Abreviaturas

```javascript
TiposDeVia = {
  AC: "Avenida Calle",
  AK: "Avenida Carrera",
  CR: "Carrera",
  CV: "Circunvalar",
  CL: "Calle",
  CC: "Cuentas Corridas",
  PJ: "Pasaje",
  PS: "Paseo",
  PT: "Peatonal",
  TV: "Transversal",
  TC: "Troncal",
  DG: "Diagonal",
  CQ: "Circular",
  SR: "Servidumbre-Peatonal",
  VR: "Vereda",
  AU: "Autopista",
  AV: "Avenida",
  BV: "Bulevar",
  KR: "Carrera",
  CT: "Carretera",
  GL: "Glorieta",
  KM: "Kilómetro",
  VT: "Variante",
  VI: "Vía",
};
```

## 5. Referencias

1. <https://turfjs.org>
