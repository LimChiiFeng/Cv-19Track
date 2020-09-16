create table User (
username varchar (15) NOT NULL PRIMARY KEY,
password varchar (15) NOT NULL,
name varchar (30) NOT NULL,
type varchar (15) NOT NULL,
CONSTRAINT check_Type CHECK (type IN ('Patient','CentreOfficer'))
);

create table Patient(
username varchar (15) NOT NULL,
patientType varchar (15) NOT NULL,
symptoms varchar (15) NOT NULL
Primary key (username),
Foreign key (username) references User(username),
CONSTRAINT check_patientType CHECK (patientType IN ('Returnee', 'Quarantined', 'Close contact', 'Infected', 'Suspected')) 
);

create table CentreOfficer(
username varchar (15) NOT NULL,
position varchar (30) NOT NULL DEFAULT('Manager'),
Primary key (username),
Foreign key (username) references User(username),
CONSTRAINT checkPosition CHECK (position IN ('Manager','Officer'))
);

create table TestCentre(
centreID int (5) NOT NULL,
username varchar(15) NOT NULL,
centreName varchar (50) NOT NULL,
Description varchar (100) NOT NULL,
image varchar(100),
Primary key (centreID),
);

create table TestKit(
centreID int (5) NOT NULL,
testName varchar (30) NOT NULL,
kitID int (10) NOT NULL,
availableStock int (1000) NOT NULL CONSTRAINT,
Primary key (centreID,kitID),
Foreign key (centreID) references TestCentre(centreID),
);

create table CovidTest(
testID int (5) NOT NULL,
testDate date NOT NULL,
kitID int (10) NOT NULL,
patientUsername varchar(15) NOT NULL,
officerUsername varchar(15) NOT NULL,
result varchar (50) NOT NULL,
resultDate date,
status varchar (30)
Primary Key (testID,kitID,patientUsername,officerUsername),
Foreign key kitID references TestKit(kitID),
Foreign key patientUsername references Patient(username),
Foreign key officerUsername references CentreOfficer(username)
);