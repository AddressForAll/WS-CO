-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- Critical scenarios that can be originated from API calls
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- Use Case #1
-- Find all addresses in Colombia
-- Returns a FeatureCollection with 474520 features
SELECT api.search('Colombia', null);
-- 
-- Use Case #2
-- Find all addresses in a 100km radius
-- Returns a FeatureCollection with 474520 features
SELECT api.search_nearby(
    'calle',
    ARRAY [-75.486799, 6.194510],
    100000,
    null
  );
-- 	
-- Use Case #3
-- Retrieve all addresses as GeoJSON (features)
-- Returns 474520 rows
SELECT api.lookup(properties->>'address') AS features
FROM api.search;