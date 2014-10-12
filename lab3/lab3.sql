/*
Sam Kreter
Sakfy6

Attempting Bonus
*/


DROP SCHEMA IF EXISTS lab3 CASCADE;
CREATE SCHEMA lab3;






CREATE TABLE lab3.building (name varchar(50) NOT NULL,
							city varchar(50) NOT NULL,
							state varchar(50) NOT NULL,
							address varchar(250) NOT NULL,
							zipcode varchar(11) NOT NULL,
							PRIMARY KEY(zipcode,address)
							);

INSERT INTO lab3.building VALUES ('Rollins','Columbia','Missouri','1201 Rollins Street','65102');
INSERT INTO lab3.building VALUES ('Stubby','Jefferson City','Missouri','1857 hopes gone drive','65104');
INSERT INTO lab3.building VALUES ('Hopes','Fulton','Missouri','1233 gonewild Street','65132');


--using the forgien key constraint to link the office to the building 
CREATE TABLE lab3.office(room_number integer PRIMARY KEY,
						 waiting_room_capacity integer NOT NULL,
						 office_zipcode varchar(11) NOT NULL,
						 office_address varchar(250) NOT NULL,
						 FOREIGN KEY(office_zipcode, office_address) REFERENCES lab3.building
						 );

INSERT INTO lab3.office VALUES(102,44,'65102','1201 Rollins Street');
INSERT INTO lab3.office VALUES(503,56,'65104','1857 hopes gone drive');
INSERT INTO lab3.office VALUES(754,44,'65132','1233 gonewild Street');
			


CREATE TABLE lab3.doctor ( medical_license_num integer PRIMARY KEY, 
						   first_name varchar(50) NOT NULL, 
						   last_name varchar(50) NOT NULL,
						   office integer REFERENCES lab3.office);

INSERT INTO lab3.doctor VALUES(60241396,'Paul','Smith');
INSERT INTO lab3.doctor VALUES(57483458,'Samuel','Kreter');
INSERT INTO lab3.doctor VALUES(57345730,'Sally','Perdue');



--SSN is forceded to store as 9
CREATE TABLE lab3.patient ( first_name varchar(50) NOT NULL,
							last_name varchar(50) NOT NULL,
							ssn integer PRIMARY KEY);

INSERT INTO lab3.patient VALUES('Sally','Sue',490551234);
INSERT INTO lab3.patient VALUES('Billy','Jole',490331245);
INSERT INTO lab3.patient VALUES('Coco','Smith',698341234);




--Time in this table is stored in minutes from midnight
--On DELETE CASCADE to delete references to deleted people
CREATE TABLE lab3.doctor_has_appointment_patient( appt_date date NOT NULL,
												  appt_time integer NOT NULL,
												  medical_license_num integer REFERENCES lab3.doctor,
												  ssn integer REFERENCES lab3.patient ON DELETE CASCADE,
												  PRIMARY KEY(ssn,medical_license_num));


INSERT INTO lab3.doctor_has_appointment_patient VALUES('1/8/2014',1005,60241396,490551234);
INSERT INTO lab3.doctor_has_appointment_patient VALUES('2/4/2014',720,57483458,490331245);
INSERT INTO lab3.doctor_has_appointment_patient VALUES('1/8/2014',840,57345730,698341234);


--On DELETE CASCADE to delete references to deleted people
CREATE TABLE lab3.insurance ( policy_num integer NOT NULL,
							  insurer varchar(50) NOT NULL,
							  patient_ssn integer PRIMARY KEY REFERENCES lab3.patient(ssn) ON DELETE CASCADE);

INSERT INTO lab3.insurance VALUES(475867,'Blue Coss',490551234);
INSERT INTO lab3.insurance VALUES(893744,'Yellow Star',490331245);
INSERT INTO lab3.insurance VALUES(987465,'Happy Fish',698341234);


CREATE TABLE lab3.condition ( icd10 varchar(8) PRIMARY KEY,
							  description varchar(100) NOT NULL);

INSERT INTO lab3.condition VALUES('Y92.253','Injured in an opera house');
INSERT INTO lab3.condition VALUES('Y92.250','Injured in an art gallery');
INSERT INTO lab3.condition VALUES('Y92.024','Injured in the driveway of a mobile home');




--On DELETE CASCADE to delete references to deleted people
CREATE TABLE lab3.patient_has_condition( ssn integer REFERENCES patient ON DELETE CASCADE,
										 icd10 varchar(8) REFERENCES condition,
										 PRIMARY KEY(ssn, icd10));

INSERT INTO lab3.patient_has_condition VALUES(490551234,'Y92.253');
INSERT INTO lab3.patient_has_condition VALUES(490331245,'Y92.250');
INSERT INTO lab3.patient_has_condition VALUES(698341234,'Y92.024');


--On DELETE CASCADE to delete references to deleted people
CREATE TABLE lab3.labwork ( test_name varchar(50) NOT NULL,
							test_timestamp timestamp NOT NULL,
							test_value integer NOT NULL,
							patient integer REFERENCES lab3.patient(ssn) ON DELETE CASCADE,
							PRIMARY KEY(test_name, test_timestamp, patient));

INSERT INTO lab3.labwork VALUES('DeadMan','2007-12-09 T 11:20',5543,490551234);
INSERT INTO lab3.labwork VALUES('Not living long','2007-11-05 T 01:20',3455,490331245);
INSERT INTO lab3.labwork VALUES('yep your screwed','2005-12-09 T 05:20',4756,698341234);
