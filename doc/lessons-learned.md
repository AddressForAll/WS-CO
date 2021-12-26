# Lecciones Aprendidas y Recomendaciones para Versiones Futuras <!-- omit in toc -->

- [1. Cuál sería la aplicación ideal, a qué público apunta y qué saca un usuario final de la interacción con ella](#1-cuál-sería-la-aplicación-ideal-a-qué-público-apunta-y-qué-saca-un-usuario-final-de-la-interacción-con-ella)
  - [1.1. Preservación de los contenidos](#11-preservación-de-los-contenidos)
  - [1.2. Uso, actualización y matenimiento de los datos](#12-uso-actualización-y-matenimiento-de-los-datos)
    - [1.2.1. RESTful API](#121-restful-api)
    - [1.2.2. WebMap App](#122-webmap-app)
    - [1.2.3. Retroalimentación, corrección e importación masiva](#123-retroalimentación-corrección-e-importación-masiva)
    - [1.2.4. ¿Qué falta?](#124-qué-falta)
- [2. Referencias](#2-referencias)

Como el alcance inicial del API incluía solo direcciones de Medellín, al incorporar las de Bogotá y eventualmente los datos de toda Colombia surgieron un grupo de nuevos requerimientos a los que se intentó encontar solución de la manera más digna posible en esta primera versión, con resultados más o menos satisfactorios. Este documento intenta allanar el camino para futuras versiones y más que una guía de como proceder es una lista de elementos a tener en cuenta a partir de lo que se podrían considerar lecciones aprendidas en las diferentes etapas del desarrollo.

## 1. Cuál sería la aplicación ideal, a qué público apunta y qué saca un usuario final de la interacción con ella

Aunque este apartado no es meramente técnico, tener claro el público mera ayudaría a centrar el desarrollo en las tareas que son realmente importantes para conseguir los objetivos planteados y dejar el resto abierto a la iniciativa de la comunidad de usarios que va siempre un paso delante de cualquier alcance que pudiéramos proponernos.  

Aquí pueden identificarse claramente dos línas de desarrollo (al menos así es como yo lo percibo): La primea encaminada a la preservación de las direcciones postales y la otra más bien centrada en poner disponibles estos datos para que sean utilizados de manera abierta o respondiendo a un plan de negocio lo cual no está para nada reñido con el paradigma de los datos libres. Así que viene quedando:

### 1.1. Preservación de los contenidos

Tiene que ver con la salvaguarda de las direcciones postales orientada a la preservación en el tiempo de los datos que las componenen garantizando la integridad y la calidad de los mismos así como la autenticidad de las fuentes de donde se obtuvieron inicialmente. Aunque para la preservación los requerimientos técnicos son relativamente sencillos y están bastante bien descritos, convertirse en autoridad de datos lleva implícito el compromiso de mantenerlos vivos e interoperables en el tiempo incluso pensar en la manera de delegar su custodia en caso de que desapareciera la organización. Se trata de fomentar en los usuarios la confuenza de que la información estará disponible siempre que la soliciten.

Una idea prodría ser compartir los datos con otra organizión que también disponga de las garantías de preservación y cumpla con los requerimientos del proyecto como por ejemplo contar con una licencia compatible. En este caso podría ser OpenStreetMap o cualqueir otra, Open Knoledege Foundation, Archive.org... A saber.

### 1.2. Uso, actualización y matenimiento de los datos

En la medida que se propicie la interacción con los datos, ya sea a través de consultas de usuarios directos, procesos de auditoría o su integración con aplicaciones de terceros; esto se deben ir validando siempre que exista una manera de canalizar la retroalimetación hacia procedimientos de atención a fallos y controles de calidad que en principio deberían encargarse de garantizar la integridad de los mismos.

De moemnto hemos estado trabajando en dos frentes: Una API RESTful y una Aplicación Web que ejecuta búsquedas a través de una de las funciones disponibles en el API `endpoints` y representa los resultados en un mapa con un nivel mínimo de interacción.

#### 1.2.1. RESTful API

Implementa 5 funciones `endpoints` mediante las cuales se puede interactuar con los datos. [Ver documentación.](definition.md)

1. Búsqueda genérica a texto completo
2. Búsqueda a texto completo en un recuadro delimitado _Bounding-box_
3. Búsqueda a texto completo en las proximidades de un punto
4. Geocodificación Inversa
5. Recuperación de direcciones

A pesar de que los resultados de las pruebas realizadas que incluyen la integración con una aplicación externa (WebMap App) han sido satisfactorios, quedó demostrado que al aumentar en 5 veces la cantidad de datos que actualmente sobrepasan los 2.1 millones de direcciones, el desempeño se ha visto considerablemente impactado; por lo que es muy recomendable modificar el esquema actual para conseguir niveles acptables de rendimientos sobre todo disminuir el tiempo de respuesta de cara al servicio.

Para conseguir un mejor desempeño la recomendación es dividir físicamente los datos manejados por el API que ahora mismo conviven en una misma vista marterializada, en vistas individuales que podrían ser subdivisiones atendiendo al `admin_level=6` que en el caso de Colombia corresponde con Ciudad/Municipio para OSM `City`. Una vez separados se obtendría el subconjunto deseado a partir de una consulta previa para seleccionar la tabla lo cual resulta considerablemente más ágil que filtrar todo el conjunto de datos cada vez que se ejecute una consulta.

Esta modificación no es nada complicado. Requeriría agregar dos funciones, adaptar las ya existentes para recibir como argumento el nombre de la tabla y reescribir el script que genera la vista actual para que gnere vistas separadas para cada ciudad.

Otra modificación que mejoraría el tiempo de respuesto seria almacenar ya construida de antemano (en geojson) cada direeción que se va a devolver en la respuesta para agilizar la construcción de la `FeatureCollection`.

#### 1.2.2. WebMap App

La Aplicación Web, más que un Producto Mínimo Viable _(MVP)_, puede considerarse una Prueba de Concepto. Al no especificarse requerimientos inciales, la implementación quedó demasiado abierta a la improvisación y aunque se lograron conciliar la mayoría de las opiniones de útimo minuto, un pliego mínimo de requisitos que definiera las funcionalidades que no podían faltar, nos hubiera hecho la vida más sencilla a todos.

De todas formas el resultado fue muy satisfactorio. Se logró una aplicación bastante robusta que si se definieran las funcionalidades se podrían implementar un grupo de mejoras para convertirla, con relativamene podo esfuerzo, en un producto listo para desempeñarse en un entrono de producción.

#### 1.2.3. Retroalimentación, corrección e importación masiva

Aquí está todo por decir. Sole mencionar que la apertura a la comunidad acarrea un compromiso con cada usuario que ofrece sus datos, su conocimeinto y su tiempo o simplemte deja un comentario o expresa su opinión. Estos procesos seguramente estarán deficnidos en alguna parte, pero el reto es buscar la manera de reflejarlos a nivel de aplicación. Ante todo lo que sea que se vaya a implementar debe estar encaminado a disminuir barreras y elimimar friccines sobre todo de intervención humana.

Por ejemplo ahora mismo ¿cómo se gestiona si un usuario, individuo o institucion, detecta que hay errores? Si tuviera datos para aportar ¿como lo hace? ¿dónde los manda? ¿con quién habla?... Nada de eso está resuelto a nivel de aplicación. Podría ser un correo electrónico, un teléfono, un formulario de contacto, un enlace a la web de Address For All.

#### 1.2.4. ¿Qué falta?

A continuación dejo una lista de algunas cosas que he echado de menos durante el desarrollo. También algunas ideas que han ido saltando después que bajó la presión de las fechas de entrega. Tengo algunas a medio documentar, scripts empezados unos que corren y otros que no, ejemplos que voy a compartir en la medida que el tiempo me lo permita.

1. Especificar un moedelo de datos. [SIT 2.0 Modelo de Datos: Direcciones Postales (slide #25)](https://www.slideshare.net/elpbatista/implementacin-de-aplicaciones-gis-en-la-habana-primeras-experiencias-utilizando-software-libre)
2. Generar un identificadores para los objetos almacenados. Podrían ser [URIs _(Uniform Resource Identifiers)_](https://en.wikipedia.org/wiki/Uniform_Resource_Identifier) o [CIDs _(Content Identifiers)_](https://proto.school/anatomy-of-a-cid) en dependencia de hacia donde se quiera llevar el proyecto.
3. Documentar la limpieza de los datos y de ser posible dejar disponible el código que se usó para este fin (scripts). En muchos casos será necesario reprocesar los mismos datos y sería saludable poder contar con la experiencia acumulada en este proceso.
4. Etiquetar todo lo que puede ser nombrado: Nombres antiguos y actuales de las calles, puntos de interés, nombres de edificios, negocios, usos...
5. Implementar un mecanismo de interpolación para las direcciones que no están almacenadas en la base de datos y que debereían existir.
6. Convención de etiquetado: Formato de direcciones, uso de mayúsculas, uso de símbolos como #, -, Nº, abreviaturas...
7. Separar físicamente los datos segín `admin_level=6` para facilitar la búsqueda.
8. Definir rutas para las diferentes `admin_level=6` que se puedan accesder desde la URL: `https://mapa.addressforall.org/co/bogota/`.
9. Almacenar por cada dirección la `feature` que se va a devolver en la respuesta.
10. Implementar un mecanismo para compartir los resultados de la búsqueda y/o su ubicación en el mapa: `permalink`.
11. Hacer la web mobile friendly/ready o desarrollar una aplicación nativa para celular.
12. Implementar un mecanismo de exportación y eventualmente de contribucón de datos.
13. Reconocer las fuentes: `add attribution` y especificar la licencia en cada caso.
14. Solicitarle al diseñador una pauta de diseño en lugar de pedirle que intervenga en el desarrollo (lo cual no dio resultado)
15. Establecer canales de retroalimentación.
16. Establecer unas pautas de estilo básicas para la documentación: Qué se documenta, cómo (código comentado, ejemplos, gráficos, texto) y en qué idioma(s) por ejemplo.

## 2. Referencias

1. <https://www.slideshare.net/elpbatista/implementacin-de-aplicaciones-gis-en-la-habana-primeras-experiencias-utilizando-software-libre>
2. <https://en.wikipedia.org/wiki/Uniform_Resource_Identifier>
3. <https://proto.school/anatomy-of-a-cid>
