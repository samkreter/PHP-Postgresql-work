--#2
DROP SCHEMA IF EXISTS lab10 CASCADE;

--#3
CREATE SCHEMA lab10;

--#4
SET search_path = lab10;


--#5
CREATE TABLE group_standings(
  team varchar(25) NOT NULL PRIMARY KEY,
  wins smallint NOT NULL CHECK(wins >= 0),
  losses smallint NOT NULL CHECK(losses >= 0),
  draws smallint NOT NULL CHECK(draws >= 0),
  points smallint NOT NULL CHECK(points >= 0)

);

<<<<<<< HEAD
--  \copy group_standings FROM /facstaff/klaricm/public_cs3380/lab10/lab10_data.csv WITH CSV HEADER
--
-- CREATE OR REPLACE FUNCTION
-- calc_batting_average_v1(integer, integer)
-- RETURNS float AS $$
-- SELECT $1 ::float / $2 AS result;
-- $$ LANGUAGE SQL;
=======

--#6
 \copy group_standings FROM /facstaff/klaricm/public_cs3380/lab10/lab10_data.csv WITH CSV HEADER

--#7
CREATE OR REPLACE FUNCTION
calc_points_total(smallint, smallint)
RETURNS integer AS $$
SELECT 3*$1 + $2 AS result;
$$ LANGUAGE SQL;


--#8
CREATE OR REPLACE FUNCTION update_points_total() RETURNS trigger AS $$
BEGIN
  NEW.points := calc_points_total(NEW.wins,NEW.draws);
RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER tr_update_points_total BEFORE INSERT OR UPDATE ON group_standings
FOR EACH ROW EXECUTE PROCEDURE update_points_total();


--#9
CREATE OR REPLACE FUNCTION disallow_team_name_update() RETURNS trigger AS $$
BEGIN
-- ensure user does not change the team name on update
IF OLD.team != NEW.team THEN
RAISE EXCEPTION 'Can not change the team on update';
END IF;
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

--#10
CREATE TRIGGER tr_disallow_team_name_update BEFORE UPDATE ON group_standings 
FOR EACH ROW EXECUTE PROCEDURE disallow_team_name_update();
>>>>>>> bc6cdfcd3f773bb586a0432014b2cfdee8c0c5de
