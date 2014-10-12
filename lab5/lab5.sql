SET search_path = lab5;


/*creates view*/
\echo #1
DROP VIEW IF EXISTS weight CASCADE;
CREATE VIEW weight AS
	SELECT	person.pid, fname, lname FROM person 
	INNER JOIN body_composition  AS bd ON person.pid = bd.pid
	WHERE weight > 140;

/*create second veiw with a reference to first veiw*/
\echo #2
DROP VIEW IF EXISTS BMI CASCADE;
CREATE VIEW BMI AS 
	SELECT fname, lname, ROUND((703*(weight/height*height))::numeric) AS BMI FROM weight
	INNER JOIN body_composition AS bd ON weight.pid = bd.pid
	WHERE weight > 150;

/*universities without people in the database*/
\echo #3
SELECT university_name, city FROM university 
WHERE NOT EXISTS (SELECT * FROM person 
				WHERE person.uid = university.uid);


/*select people from universities in columbia */
\echo #4
SELECT fname, lname FROM person 
WHERE uid IN (SELECT uid FROM university WHERE city ILIKE 'columbia');


/*finds activities not perticipated in. */
\echo #5
SELECT activity_name FROM activity
WHERE activity_name NOT IN (SELECT activity_name FROM participated_in);


/*find people in racquetball and running*/
\echo #6
SELECT pid FROM participated_in WHERE activity_name ILIKE 'racquetball'
UNION
SELECT pid FROM participated_in WHERE activity_name ILIKE 'running';


/*finds people with both an aga and heigth constrain*/ 
\echo #7
SELECT fname, lname FROM person INNER JOIN body_composition AS bc ON person.pid = bc.pid WHERE age > 30
INTERSECT
SELECT fname, lname FROM person INNER JOIN body_composition AS bc ON person.pid = bc.pid WHERE height > 65;


/*order the return queries*/ 
\echo #8
SELECT fname, lname, weight, height, age FROM person INNER JOIN 
	body_composition AS bc ON person.pid = bc.pid
	ORDER BY height DESC, weight ASC, lname ASC;

/*uses the with keyword */
\echo #9
WITH CTE AS (SELECT pid, fname, lname FROM person INNER JOIN 
	university AS un ON person.uid = un.uid
	WHERE un.university_name ILIKE 'University of Missouri Columbia')
SELECT * FROM body_composition INNER JOIN CTE ON CTE.pid = body_composition.pid;

/*uses the with keyword for updating */
\echo #10 
WITH hello AS (SELECT person.pid FROM person INNER JOIN body_composition 
	ON person.pid = body_composition.pid
	WHERE person.uid != 2 AND height > 70) 
UPDATE person SET uid = 2 
	FROM hello
	WHERE hello.pid = person.pid;





