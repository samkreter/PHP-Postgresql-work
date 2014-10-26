set search_path = lab7;
/*
  1)The reason this query used an index was because postgres will automaticly create an index
  on the primary key for more efficent querying of that key.

*/

--##########################################################################################

\echo #2
DROP INDEX IF EXISTS banks_state_idx;
EXPLAIN ANALYZE SELECT name FROM lab7.banks WHERE state LIKE 'Missouri';

/*                                                     QUERY PLAN
-------------------------------------------------------------------------------------------------------
Seq Scan on banks  (cost=0.00..894.98 rows=996 width=29) (actual time=0.458..19.873 rows=996 loops=1)
  Filter: ((state)::text ~~ 'Missouri'::text)
Total runtime: 20.057 ms
(3 rows)
 */
 CREATE INDEX ON banks(state);

 EXPLAIN ANALYZE SELECT name FROM lab7.banks WHERE state LIKE 'Missouri';

 /*
CREATE INDEX
                                                         QUERY PLAN
-----------------------------------------------------------------------------------------------------------------------------
 Bitmap Heap Scan on banks  (cost=23.97..598.42 rows=996 width=29) (actual time=0.471..2.063 rows=996 loops=1)
   Filter: ((state)::text ~~ 'Missouri'::text)
   ->  Bitmap Index Scan on banks_state_idx  (cost=0.00..23.72 rows=996 width=0) (actual time=0.334..0.334 rows=996 loops=1)
         Index Cond: ((state)::text = 'Missouri'::text)
 Total runtime: 2.236 ms
(5 rows)
*/

/*
  The index was faster by 17.821ms or 897% faster
*/
--########################################################################################
\echo #3
DROP INDEX IF EXISTS banks_name_idx;
SELECT * FROM lab7.banks ORDER BY name;
EXPLAIN ANALYZE SELECT name FROM lab7.banks ORDER BY name;
/*                                                 QUERY PLAN
----------------------------------------------------------------------------------------------------------------
 Sort  (cost=3523.15..3592.14 rows=27598 width=29) (actual time=181.372..207.874 rows=27598 loops=1)
   Sort Key: name
   Sort Method: external merge  Disk: 1064kB
   ->  Seq Scan on banks  (cost=0.00..825.98 rows=27598 width=29) (actual time=0.008..5.928 rows=27598 loops=1)
 Total runtime: 209.141 ms

*/
CREATE INDEX ON banks(name);
EXPLAIN ANALYZE SELECT name FROM lab7.banks ORDER BY name;
/*
                                                            QUERY PLAN
-----------------------------------------------------------------------------------------------------------------------------------
 Index Scan using banks_name_idx on banks  (cost=0.00..3294.27 rows=27598 width=29) (actual time=0.024..11.439 rows=27598 loops=1)
 Total runtime: 12.483 ms
(2 rows)
*/
/*
  The index was gaster by 196.658ms and 1675.4% faster
*/

--##########################################################################################

\echo #4
DROP INDEX IF EXISTS banks_is_acitve_idx;
CREATE INDEX ON banks(is_active);

--#############################################################################################

\echo #5
SELECT * FROM banks WHERE is_active = TRUE;
EXPLAIN ANALYZE SELECT * FROM banks WHERE is_active = TRUE;
/*                                                         QUERY PLAN
-------------------------------------------------------------------------------------------------------------------------------------
 Bitmap Heap Scan on banks  (cost=132.77..750.53 rows=6776 width=124) (actual time=0.660..1.992 rows=6776 loops=1)
   Filter: is_active
   ->  Bitmap Index Scan on banks_is_active_idx2  (cost=0.00..131.07 rows=6776 width=0) (actual time=0.594..0.594 rows=6776 loops=1)
         Index Cond: (is_active = true)
 Total runtime: 2.256 ms

*/
SELECT * FROM banks WHERE is_active = FALSE;
EXPLAIN ANALYZE SELECT * FROM banks WHERE is_active = FALSE;

/*
                                                QUERY PLAN
-----------------------------------------------------------------------------------------------------------
 Seq Scan on banks  (cost=0.00..825.98 rows=20822 width=124) (actual time=0.015..9.561 rows=20822 loops=1)
   Filter: (NOT is_active)
 Total runtime: 12.065 ms

*/
/*
  The query that returned when is_active is true was the only one that used indexs.
  This is because since it returned a smaller number it was more efficent for the database
  to use the index instead of a sequencial search.

  The false query used a sequencial search because it is less efficent to go through so many
  entries with the index becuase of the overhead associated with the index so the dbms automaticly
  switches to using a seq search
*/
--############################################################################################
\echo #6
DROP INDEX IF EXISTS banks_insured_idx;
SELECT * FROM banks WHERE insured >= '2000-01-01';
EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01'::date;
/*
                                               QUERY PLAN
---------------------------------------------------------------------------------------------------------
 Seq Scan on banks  (cost=0.00..894.98 rows=1450 width=124) (actual time=1.424..5.448 rows=1451 loops=1)
   Filter: (insured >= '2000-01-01'::date)
 Total runtime: 5.605 ms

*/
CREATE INDEX ON banks(insured) WHERE insured != '1934-01-01'::date;
EXPLAIN ANALYZE SELECT * FROM banks WHERE insured >= '2000-01-01'::date;
/*
                                                            QUERY PLAN
-----------------------------------------------------------------------------------------------------------------------------------
 Index Scan using banks_insured_idx on banks  (cost=0.00..573.89 rows=1450 width=124) (actual time=0.026..0.457 rows=1451 loops=1)
   Index Cond: (insured >= '2000-01-01'::date)
 Total runtime: 0.509 ms
*/
/*
  The index was faster by 5.096ms and 1101.1% faster
*/

--############################################################################################

\echo #7
DROP INDEX IF EXISTS banks_expr_idx;
EXPLAIN ANALYZE SELECT id, name, city, state, assets, deposits
FROM banks WHERE deposits != 0 AND (assets/deposits) < 0.5;
/*
                                               QUERY PLAN
---------------------------------------------------------------------------------------------------------
 Seq Scan on banks  (cost=0.00..1032.97 rows=9166 width=63) (actual time=26.885..32.021 rows=46 loops=1)
   Filter: ((deposits <> 0::numeric) AND ((assets / deposits) < 0.5))
 Total runtime: 32.076 ms

*/

CREATE INDEX ON banks((assets/deposits)) WHERE deposits != 0;

EXPLAIN ANALYZE SELECT id, name, city, state, assets, deposits
FROM banks WHERE deposits != 0 AND (assets/deposits) < 0.5;
/*
-----------------------------------------------------------------------------------------------------------------------------
 Bitmap Heap Scan on banks  (cost=215.54..925.95 rows=9166 width=63) (actual time=0.108..0.200 rows=46 loops=1)
   Recheck Cond: (((assets / deposits) < 0.5) AND (deposits <> 0::numeric))
   ->  Bitmap Index Scan on banks_expr_idx  (cost=0.00..213.25 rows=9166 width=0) (actual time=0.083..0.083 rows=46 loops=1)
         Index Cond: ((assets / deposits) < 0.5)
 Total runtime: 0.253 ms
*/
/*
The index was faster by 31.823ms and is 1278.3% faster
*/
