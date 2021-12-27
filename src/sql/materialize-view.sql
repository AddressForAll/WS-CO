CREATE MATERIALIZED VIEW api.search AS -- 
WITH administrative AS (
  SELECT *
  FROM jplanet_osm_polygon
  WHERE tags->>'boundary' = 'administrative'
    AND tags->>'admin_level' = '6'
)
SELECT r._id AS _id,
  r.geom AS geom,
  REPLACE(
    (
      lower(
        CONCAT(
          r.address,
          ' ',
          r.nombre,
          ' ',
          r.display_name,
          ' ',
          r.barrio,
          ' ',
          r.comuna
        )
      )::tsvector
    )::text,
    '''',
    ''
  ) AS spq,
  REPLACE(
    (
      lower(
        CONCAT(
          r.address,
          ' ',
          r.nombre,
          ' ',
          r.display_name,
          ' ',
          r.barrio,
          ' ',
          r.comuna,
          ' ',
          r.city,
          ' ',
          r.municipality,
          ' ',
          r.country,
          ' ',
          r.divipola,
          ' ',
          r.postcode
        )
      )::tsvector
    )::text,
    '''',
    ''
  ) AS q,
  jsonb_strip_nulls(
    to_jsonb(r) #-'{geom}') AS properties
    FROM (
        SELECT pts.id AS _id,
          pts.geom AS geom,
          pts.properties->>'address' AS address,
          pts.properties->>'display_name' AS display_name,
          REPLACE(pts.properties->>'via_name', 'null', '') AS nombre,
          pts.properties->>'nombre_bar' AS barrio,
          pts.properties->>'nombre_com' AS comuna,
          pts.properties->>'city' AS city,
          pts.properties->>'postcode' AS postcode,
          administrative.tags->>'divipola' AS divipola,
          administrative.tags->>'is_in:state' AS municipality,
          administrative.tags->>'is_in:country' AS country
        FROM pts_medellin_bogota pts
          LEFT JOIN administrative ON ST_Contains(administrative.way, pts.geom)
      ) r;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Indexing for the Search
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
CREATE INDEX search_geom_sp_idx ON api.search USING SPGIST (geom);
CREATE INDEX search_geom_idx ON api.search USING GIST (geom);
CREATE INDEX search_properties_idx ON api.search USING GIN (properties jsonb_ops);
CREATE INDEX search_properties_address_idx ON api.search USING GIN ((properties->'address'));
CREATE INDEX search_properties_display_name_idx ON api.search USING GIN ((properties->'display_name'));
CREATE INDEX search_properties_id_idx ON api.search USING GIN ((properties->'_id'));
CREATE INDEX search_q_trgm_idx ON api.search USING GIN (q gin_trgm_ops);
-- CREATE INDEX search_spq_trgm_idx ON api.search USING GIN (spq gin_trgm_ops);
CREATE INDEX search_spq_trgm_idx ON api.search USING GIST (spq gist_trgm_ops);