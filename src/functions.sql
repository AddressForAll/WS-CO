-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- ViewBox To Polygon
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-- FUNCTION: api.viewbox_to_polygon(numeric, numeric, numeric, numeric)
-- DROP FUNCTION IF EXISTS api.viewbox_to_polygon(numeric, numeric, numeric, numeric);
CREATE OR REPLACE FUNCTION api.viewbox_to_polygon(
		minx numeric,
		miny numeric,
		maxx numeric,
		maxy numeric
	) RETURNS text LANGUAGE 'sql' COST 100 VOLATILE PARALLEL UNSAFE AS $BODY$
SELECT ST_AsText(
		ST_Envelope(
			ST_Collect(
				ST_Point(minx, miny),
				ST_Point(maxx, maxy)
			)
		)
	) $BODY$;
ALTER FUNCTION api.viewbox_to_polygon(numeric, numeric, numeric, numeric) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.viewbox_to_polygon(numeric, numeric, numeric, numeric) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.viewbox_to_polygon(numeric, numeric, numeric, numeric) TO batista;
GRANT EXECUTE ON FUNCTION api.viewbox_to_polygon(numeric, numeric, numeric, numeric) TO postgres;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Get Center Point
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.get_centroid()
-- DROP FUNCTION IF EXISTS api.get_centroid();
CREATE OR REPLACE FUNCTION api.get_centroid() RETURNS jsonb LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$
SELECT to_jsonb(ST_centroid(ST_AsText(ST_Extent(geom)))) AS centroid
FROM api.search;
$BODY$;
ALTER FUNCTION api.get_centroid() OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.get_centroid() TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.get_centroid() TO batista;
GRANT EXECUTE ON FUNCTION api.get_centroid() TO postgres;
COMMENT ON FUNCTION api.get_centroid() IS 'Returns the center point of the polygon that contains all addresses in api.search';
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Full Text Generic Search
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.search(text, integer)
-- DROP FUNCTION IF EXISTS api.search(text, integer);
CREATE OR REPLACE FUNCTION api.search(_q text, lim integer DEFAULT 100) RETURNS json LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$ WITH q AS (
		SELECT *,
			lower(_q) <->q AS diff
		FROM api.search
		ORDER BY diff
		LIMIT lim
	)
SELECT json_build_object(
		'type',
		'FeatureCollection',
		'query',
		_q,
		'features',
		j.features
	) AS response
FROM (
		SELECT json_agg(ST_AsGeoJSON(r, 'geom', 6)::json) AS features
		FROM (
				SELECT s.geom,
					1 - s.diff AS similarity,
					s.properties->>'_id' AS _id,
					s.properties->>'address' AS address,
					s.properties->>'display_name' AS display_name,
					s.properties->>'barrio' AS barrio,
					s.properties->>'comuna' AS comuna,
					s.properties->>'municipality' AS municipality,
					s.properties->>'divipola' AS divipola,
					s.properties->>'country' AS country
				FROM (
						SELECT *
						FROM q
						WHERE q.diff < (
								SELECT MIN(diff) + MIN(diff) / 10 AND q.diff <.85
								FROM q
							)
					) s
			) r
	) j;
$BODY$;
ALTER FUNCTION api.search(text, integer) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.search(text, integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.search(text, integer) TO batista;
GRANT EXECUTE ON FUNCTION api.search(text, integer) TO postgres;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Full Text Search Bounded
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.search_bounded(text, numeric[], integer)
-- DROP FUNCTION IF EXISTS api.search_bounded(text, numeric[], integer);
CREATE OR REPLACE FUNCTION api.search_bounded(
		_q text,
		viewbox numeric [],
		lim integer DEFAULT 100
	) RETURNS json LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$ WITH q AS (
		SELECT *,
			(
				(lower(_q) <->spq) + (lower(_q) <->(properties->>'address')::text) + (
					lower(_q) <->(properties->>'display_name')::text
				)
			) / 3 AS diff
		FROM (
				SELECT *
				FROM api.search
				WHERE ST_Contains(
						ST_SetSRID(
							api.viewbox_to_polygon(viewbox [1], viewbox [2], viewbox [3], viewbox [4]),
							4326
						),
						geom
					)
			) q
		ORDER BY diff
		LIMIT lim
	)
SELECT json_build_object(
		'type',
		'FeatureCollection',
		'query',
		_q,
		'features',
		j.features
	) AS response
FROM (
		SELECT json_agg(ST_AsGeoJSON(r, 'geom', 6)::json) AS features
		FROM (
				SELECT s.geom,
					1 - s.diff AS similarity,
					s.properties->>'_id' AS _id,
					s.properties->>'address' AS address,
					s.properties->>'display_name' AS display_name,
					s.properties->>'barrio' AS barrio,
					s.properties->>'comuna' AS comuna,
					s.properties->>'municipality' AS municipality,
					s.properties->>'divipola' AS divipola,
					s.properties->>'country' AS country
				FROM (
						SELECT *
						FROM q
						WHERE q.diff < (
								SELECT MIN(diff) + MIN(diff) / 10 AND q.diff <.85
								FROM q
							)
					) s
			) r
	) j $BODY$;
ALTER FUNCTION api.search_bounded(text, numeric [], integer) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.search_bounded(text, numeric [], integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.search_bounded(text, numeric [], integer) TO batista;
GRANT EXECUTE ON FUNCTION api.search_bounded(text, numeric [], integer) TO postgres;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Full Text Search Nearby
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.search_nearby(text, numeric[], numeric, integer)
-- DROP FUNCTION IF EXISTS api.search_nearby(text, numeric[], numeric, integer);
CREATE OR REPLACE FUNCTION api.search_nearby(
		_q text,
		loc numeric [],
		radius numeric DEFAULT 200,
		lim integer DEFAULT 100
	) RETURNS json LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$ WITH q AS (
		SELECT *,
			(
				(lower(_q) <->spq) + (lower(_q) <->(properties->>'address')::text) + (
					lower(_q) <->(properties->>'display_name')::text
				)
			) / 3 AS diff
		FROM (
				SELECT *
				FROM (
						SELECT *,
							s.geom::geography <->ST_POINT(loc [1], loc [2]) as dist
						FROM api.search s
					) b
				WHERE b.dist <= radius
			) q
		ORDER BY diff,
			dist
		LIMIT lim
	)
SELECT json_build_object(
		'type',
		'FeatureCollection',
		'query',
		_q,
		'features',
		j.features
	) AS response
FROM (
		SELECT json_agg(ST_AsGeoJSON(r, 'geom', 6)::json) AS features
		FROM (
				SELECT s.geom,
					1 - s.diff AS similarity,
					round(s.dist, 2) AS distance,
					s.properties->>'_id' AS _id,
					s.properties->>'address' AS address,
					s.properties->>'display_name' AS display_name,
					s.properties->>'barrio' AS barrio,
					s.properties->>'comuna' AS comuna,
					s.properties->>'municipality' AS municipality,
					s.properties->>'divipola' AS divipola,
					s.properties->>'country' AS country
				FROM (
						SELECT *
						FROM q
						WHERE q.diff < (
								SELECT MIN(diff) + MIN(diff) / 10 AND q.diff <.85
								FROM q
							)
					) s
			) r
	) j $BODY$;
ALTER FUNCTION api.search_nearby(text, numeric [], numeric, integer) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.search_nearby(text, numeric [], numeric, integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.search_nearby(text, numeric [], numeric, integer) TO batista;
GRANT EXECUTE ON FUNCTION api.search_nearby(text, numeric [], numeric, integer) TO postgres;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Reverse Geocoding
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.reverse(numeric, numeric, numeric, integer)
-- DROP FUNCTION IF EXISTS api.reverse(numeric, numeric, numeric, integer);
CREATE OR REPLACE FUNCTION api.reverse(
		lon numeric,
		lat numeric,
		radius numeric DEFAULT 3,
		lim integer DEFAULT 1
	) RETURNS json LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$ WITH nearby AS (
		SELECT *,
			b.geom::geography <->ST_POINT(lon, lat) as dist
		FROM (
				SELECT *
				FROM api.search s
				WHERE ST_DWithin(
						s.geom::geography,
						ST_POINT(lon, lat),
						radius
					)
			) b
		ORDER BY dist
		LIMIT lim
	)
SELECT CASE
		j.features_count
		WHEN 1 THEN j.features
		ELSE json_build_object(
			'type',
			'FeatureCollection',
			'features',
			j.features
		)
	END AS response
FROM (
		SELECT count(r) AS features_count,
			json_agg(ST_AsGeoJSON(r, 'geom', 6)::json) AS features
		FROM (
				SELECT s.geom,
					round(s.dist, 2) AS distance,
					s.properties->>'_id' AS _id,
					s.properties->>'address' AS address,
					s.properties->>'display_name' AS display_name,
					s.properties->>'barrio' AS barrio,
					s.properties->>'comuna' AS comuna,
					s.properties->>'municipality' AS municipality,
					s.properties->>'divipola' AS divipola,
					s.properties->>'country' AS country
				FROM (
						SELECT *
						FROM nearby
					) s
			) r
	) j;
$BODY$;
ALTER FUNCTION api.reverse(numeric, numeric, numeric, integer) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.reverse(numeric, numeric, numeric, integer) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.reverse(numeric, numeric, numeric, integer) TO batista;
GRANT EXECUTE ON FUNCTION api.reverse(numeric, numeric, numeric, integer) TO postgres;
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Address Lookup
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- FUNCTION: api.lookup(text)
-- DROP FUNCTION IF EXISTS api.lookup(text);
CREATE OR REPLACE FUNCTION api.lookup(address text) RETURNS json LANGUAGE 'sql' COST 100 IMMUTABLE PARALLEL UNSAFE AS $BODY$
SELECT json_build_object(
		'type',
		'Feature',
		'geometry',
		ST_AsGeoJSON(geom, 6, 0)::json,
		'properties',
		properties
	) AS result
FROM (
		SELECT *
		FROM api.search s
		WHERE s.properties->>'address' = address
			OR s.properties->>'_id' = address
	) r $BODY$;
ALTER FUNCTION api.lookup(text) OWNER TO postgres;
GRANT EXECUTE ON FUNCTION api.lookup(text) TO PUBLIC;
GRANT EXECUTE ON FUNCTION api.lookup(text) TO batista;
GRANT EXECUTE ON FUNCTION api.lookup(text) TO postgres;