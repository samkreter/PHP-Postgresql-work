#Query1
SELECT name10 AS name FROM tl_2010_us_state10
WHERE ST_Intersects(coords,
  ST_SetSRID(ST_MakeBox2D(ST_Point(-110, 35), ST_Point(-109, 36)), 4326));
