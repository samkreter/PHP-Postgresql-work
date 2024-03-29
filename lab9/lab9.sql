--Query1
SELECT name10 AS name FROM tl_2010_us_state10
WHERE ST_Intersects(coords,
  ST_SetSRID(ST_MakeBox2D(ST_Point(-110, 35), ST_Point(-109, 36)), 4326));

--Query2
SELECT stusps10 AS USPS, name10 AS name
FROM tl_2010_us_state10 WHERE ST_Touches(coords,
  (SELECT coords FROM tl_2010_us_state10
    WHERE stusps10 IN ('NC'))) ORDER BY name ASC;
--Query3
SELECT name10 AS name FROM tl_2010_us_uac10
WHERE ST_Within(coords,
  (SELECT coords FROM tl_2010_us_state10
    WHERE stusps10 IN ('CO'))) ORDER BY name ASC;
--Query4
SELECT name10 AS name, ((aland10 + awater10)*.001) AS area
FROM tl_2010_us_uac10 WHERE ST_Overlaps(coords,
  (SELECT coords FROM tl_2010_us_state10
    WHERE stusps10 IN ('PA'))) ORDER BY area DESC;
--Query5
SELECT one.name10 AS nameOne, two.name10 AS nameTwo
FROM tl_2010_us_uac10 AS one, tl_2010_us_uac10 AS two
WHERE ST_Intersects(one.coords, two.coords) AND  one.gid != two.gid AND one.gid < two.gid;
--Query6
SELECT u.name10, COUNT(ST_Intersects(s.coords,u.coords)) AS statesInterCount FROM tl_2010_us_uac10 AS u CROSS JOIN tl_2010_us_state10 AS s
WHERE ST_Intersects(s.coords,u.coords)
GROUP BY u.gid
HAVING (u.aland10+u.awater10)/1000000 > 1500 and count(ST_Intersects(s.coords,u.coords)) > 1
ORDER BY statesInterCount, u.name10;
