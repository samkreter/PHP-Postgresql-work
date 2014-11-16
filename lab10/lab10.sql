DROP SCHEMA IF EXISTS lab10 CASCADE;

CREATE SCHEMA lab10;

SET search_path = lab10;

CREATE TABLE group_standing(
  team varchar(25) NOT NULL PRIMARY KEY,
  wins smallint NOT NULL CHECK(wins >= 0),
  losses smallint NOT NULL CHECK(losses >= 0),
  draws smallint NOT NULL CHECK(draws >= 0),
  points smallint NOT NULL CHECK(points >= 0)

);

 \copy group_standings FROM /facstaff/klaricm/public_cs3380/lab10/lab10_data.csv WITH CSV HEADER
