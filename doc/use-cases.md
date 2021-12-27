# API Casos de Uso <!-- omit in toc -->

- [1. Búsqueda de Texto Completo](#1-búsqueda-de-texto-completo)
  - [1.1. Búsqueda Genérica](#11-búsqueda-genérica)
    - [1.1.1. Llamada RPC](#111-llamada-rpc)
  - [1.2. Búsqueda Delimitada Espacialmente (¡Recomendada!) :rocket:](#12-búsqueda-delimitada-espacialmente-recomendada-rocket)
    - [1.2.1. Búsqueda en un recuadro delimitado _Bounding-box_](#121-búsqueda-en-un-recuadro-delimitado-bounding-box)
    - [1.2.2. Búsqueda en las proximidades de un punto](#122-búsqueda-en-las-proximidades-de-un-punto)
- [2. Geocodificación Inversa](#2-geocodificación-inversa)
- [3. Recuperación de direcciones](#3-recuperación-de-direcciones)
- [4. References](#4-references)

## 1. Búsqueda de Texto Completo

Recuperar direcciones como objetos geográficos GeoJSON, a partir de texto en lenguaje natural. Devuelve coincidencias parciales mayores del 5% con una cadena de entrada de al menos 3 caracteres. Es inmune al uso de mayúsculas, caracteres alfanuéricos y pequeñas variaciones como errores ortográficos y de tipado.

### 1.1. Búsqueda Genérica

Compara la cadena de entrada con el contenido de **todos** los campos `properties` exceptuando `_id` y `geometry`. Devuelve un GeoJSON con las primeras 100 (valor de 'lim' por defecto) coincidencias ordenadas según la similitud.

La respuesta incluye la cadena de entrada en `query` y la similitud por cada dirección en `properties.similarity`.

En el sigueinte ejemplo se busca la dirección más parecida a `Calle 95 #69-61`. Para obetner una sola dirección se ha restringido la cantidad de resultados `lim=1`.

<http://api.addressforall.org/test/search?_q=Calle%2095%20%2369-61&lim=1>

```json
[
  {
    "type": "Feature",
    "geometry": {
      "type": "Point",
      "coordinates": [-75.57377, 6.290209]
    },
    "properties": {
      "similarity": 0.24561405181884766,
      "_id": "57338",
      "address": "CL 95 #69-61",
      "display_name": "Calle 95 #69-61",
      "barrio": "Castilla",
      "comuna": "CASTILLA",
      "municipality": "Antioquia",
      "divipola": "05001",
      "country": "Colombia"
    }
  }
]
```

En el sigueinte ejemplo se busca `CL 107 42 Popular`. Para obetner solo tres direcciones se ha restringido la cantidad de resultados `lim=3`. Nótese que que en los dos primeros resultados la similitud es exactamente la misma `"similarity": 0.27868854999542236`.

<http://api.addressforall.org/test/search?_q=CL%20107%2042%20Popular&lim=3>

```json
{
  "type": "FeatureCollection",
  "query": "CL 107 42 Popular",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.548216, 6.296636]
      },
      "properties": {
        "similarity": 0.27868854999542236,
        "_id": "44088",
        "address": "CL 107E #42C-42",
        "display_name": "Calle 107E #42C-42",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.548093, 6.296]
      },
      "properties": {
        "similarity": 0.27868854999542236,
        "_id": "340868",
        "address": "CL 107C #42B-42",
        "display_name": "Calle 107C #42B-42",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.54852, 6.296365]
      },
      "properties": {
        "similarity": 0.27419352531433105,
        "_id": "185990",
        "address": "CL 107D #42D-07",
        "display_name": "Calle 107D #42D-07",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    }
  ]
}
```

#### 1.1.1. Llamada RPC

La misma consulta también se puede hacer mediante RPC o _Remote Procedure Call_ llamada a procedimiento remoto en Español. Con la ventaja de que la cadena de búsqueda no requiere ir codificada como URL `{"_q":"CL 107C #42B-42 Popular", "lim":3}`

```batch
curl -X POST \
  http://api.addressforall.org/test/_sql/rpc/search \
  -H 'Content-Type: application/json' \
  -d '{"_q":"CL 107C #42B-42 Popular", "lim":3}'
```

### 1.2. Búsqueda Delimitada Espacialmente (¡Recomendada!) :rocket:

En este tipo de búsqueda la cadena de entrada se compara con el contenido de los campos `properties` que no pueden ser obtenidos a partir de ralaciones espaciales lo cual incrementa considerablemente el porciento de coincidencia cuando se trata de direcciones referidas en lenguaje natural. Por otro lado, al aplicar una restricción espacial la consulta siempre se realiza en un subconjunto reducido de toos el conjunto de datos impactando considerablemente el desempeño en cuanto al tiempo de respuesta.

#### 1.2.1. Búsqueda en un recuadro delimitado _Bounding-box_

Es la que se usa en aplicaciones de WebMapping donde se puede obtener el recuadro correspondiente a la representación `viewbox` para pasárselo como argumento a la búsqueda además de la cadene en cuestión.

```batch
curl -X POST \
  http://api.addressforall.org/test/_sql/rpc/search_bounded \
  -H 'Content-Type: application/json' \
  -d '{"_q":"CL 107C #42B-42 Popular", "viewbox":[-75.552, 6.291, -75.543, 6.297], "lim":3}'
```

```json
{
  "type": "FeatureCollection",
  "query": "CL 107C #42B-42 Popular",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.548093, 6.296]
      },
      "properties": {
        "similarity": 0.8076923,
        "_id": "340868",
        "address": "CL 107C #42B-42",
        "display_name": "Calle 107C #42B-42",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.547945, 6.295895]
      },
      "properties": {
        "similarity": 0.71428573,
        "_id": "82402",
        "address": "CL 107C #42B-18",
        "display_name": "Calle 107C #42B-18",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.548163, 6.295952]
      },
      "properties": {
        "similarity": 0.71428573,
        "_id": "18106",
        "address": "CL 107C #42B-47",
        "display_name": "Calle 107C #42B-47",
        "barrio": "Popular",
        "comuna": "POPULAR",
        "municipality": "Antioquia",
        "divipola": "05001",
        "country": "Colombia"
      }
    }
  ]
}
```

#### 1.2.2. Búsqueda en las proximidades de un punto

Encuentra las coindidencias más cercanas a una localización dada. Se le pasa una coordenada `loc=[lat, lon]` junto con la cadena de búsqueda. Devuele además de la similitud, la distancia al punto que recibe como parámetro en `properties.distance`.

```batch
curl -X POST \
  http://api.addressforall.org/test/_sql/rpc/search_nearby \
  -H 'Content-Type: application/json' \
  -d '{"_q":"Calle 1BB #48A ESTE-522 El Cerro", "loc":[-75.486799, 6.194510],"radius":200, "lim":3}'
```

```json
{
  "type": "FeatureCollection",
  "query": "Calle 1BB #48A ESTE-522 El Cerro",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.4868, 6.194511]
      },
      "properties": {
        "similarity": 0.63829786,
        "distance": 0.13,
        "_id": "443091",
        "address": "CL 1BB #48A ESTE-522 (0130)",
        "display_name": "Calle 1BB #48A ESTE-522 (0130)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.486694, 6.194649]
      },
      "properties": {
        "similarity": 0.63829786,
        "distance": 19.3,
        "_id": "360091",
        "address": "CL 1BB #48A ESTE-522 (0135)",
        "display_name": "Calle 1BB #48A ESTE-522 (0135)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.485823, 6.193292]
      },
      "properties": {
        "similarity": 0.50980395,
        "distance": 173.14,
        "_id": "194489",
        "address": "CL 1BB #48A ESTE-621 (0109)",
        "display_name": "Calle 1BB #48A ESTE-621 (0109)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    }
  ]
}
```

## 2. Geocodificación Inversa

<http://api.addressforall.org/test/reverse?lon=-75.486799&lat=6.194510>

```json
[
  {
    "type": "Feature",
    "geometry": {
      "type": "Point",
      "coordinates": [-75.4868, 6.194511]
    },
    "properties": {
      "distance": 0.13,
      "_id": "443091",
      "address": "CL 1BB #48A ESTE-522 (0130)",
      "display_name": "Calle 1BB #48A ESTE-522 (0130)",
      "barrio": "El Cerro",
      "comuna": "SANTA ELENA",
      "municipality": "Antioquia",
      "divipola": "05266",
      "country": "Colombia"
    }
  }
]
```

<http://api.addressforall.org/test/reverse?lon=-75.486799&lat=6.194510&radius=200&lim=3>

```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.4868, 6.194511]
      },
      "properties": {
        "distance": 0.13,
        "_id": "443091",
        "address": "CL 1BB #48A ESTE-522 (0130)",
        "display_name": "Calle 1BB #48A ESTE-522 (0130)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.486694, 6.194649]
      },
      "properties": {
        "distance": 19.3,
        "_id": "360091",
        "address": "CL 1BB #48A ESTE-522 (0135)",
        "display_name": "Calle 1BB #48A ESTE-522 (0135)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    },
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [-75.486234, 6.194748]
      },
      "properties": {
        "distance": 67.78,
        "_id": "195150",
        "address": "CR 51 ESTE #1BB-149 (0103)",
        "display_name": "Circunvalar 51 ESTE #1BB-149 (0103)",
        "barrio": "El Cerro",
        "comuna": "SANTA ELENA",
        "municipality": "Antioquia",
        "divipola": "05266",
        "country": "Colombia"
      }
    }
  ]
}
```

## 3. Recuperación de direcciones

<http://api.addressforall.org/test/lookup?address=443091>  
<http://api.addressforall.org/test/lookup?address=CL%201BB%20%2348A%20ESTE-522%20%280130%29>

```json
{
  "type": "Feature",
  "geometry": {
    "type": "Point",
    "coordinates": [-75.4868, 6.194511]
  },
  "properties": {
    "_id": 443091,
    "city": "Envigado",
    "cruce": "CL 48A ESTE",
    "barrio": "El Cerro",
    "comuna": "SANTA ELENA",
    "address": "CL 1BB #48A ESTE-522 (0130)",
    "country": "Colombia",
    "divipola": "05266",
    "display_name": "Calle 1BB #48A ESTE-522 (0130)",
    "municipality": "Antioquia"
  }
}
```

## 4. References

1. <https://www.urlencoder.io>
