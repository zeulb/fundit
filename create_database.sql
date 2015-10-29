DROP TABLE fundit_contribution CASCADE CONSTRAINTS;
DROP TABLE fundit_project CASCADE CONSTRAINTS;
DROP TABLE fundit_user CASCADE CONSTRAINTS;
DROP TABLE fundit_roles CASCADE CONSTRAINTS;
DROP SEQUENCE fundit_contribution_seq;
DROP SEQUENCE fundit_project_seq;
DROP SEQUENCE fundit_user_seq;

CREATE TABLE fundit_roles (name VARCHAR(10) PRIMARY KEY);

CREATE TABLE fundit_user (
  id INT PRIMARY KEY,
  roles VARCHAR(10) NOT NULL,
  name VARCHAR(32) NOT NULL,
  email VARCHAR(32) NOT NULL,
  password VARCHAR(32) NOT NULL,
  FOREIGN KEY (roles) REFERENCES fundit_roles(name) ON DELETE CASCADE
);
  
CREATE SEQUENCE fundit_user_seq;

CREATE OR REPLACE TRIGGER fundit_user_bir
BEFORE INSERT ON fundit_user
FOR EACH ROW

BEGIN
  SELECT fundit_user_seq.NEXTVAL
  INTO :new.id
  FROM dual;
END;
/
CREATE TABLE fundit_project (
  id INT PRIMARY KEY,
  owner_id INT NOT NULL,
  title VARCHAR(64) NOT NULL,
  description VARCHAR(64) NOT NULL,
  goal REAL NOT NULL,
  deadline TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES fundit_user(id) ON DELETE CASCADE
);
  
CREATE SEQUENCE fundit_project_seq;

CREATE OR REPLACE TRIGGER fundit_project_bir
BEFORE INSERT ON fundit_project
FOR EACH ROW

BEGIN
  SELECT fundit_project_seq.NEXTVAL
  INTO :new.id
  FROM dual;
END;
/

CREATE TABLE fundit_contribution (
  id INT PRIMARY KEY,
  contributor_id INT NOT NULL,
  project_id INT NOT NULL,
  amount REAL NOT NULL,
  FOREIGN KEY (contributor_id) REFERENCES fundit_user(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES fundit_project(id) ON DELETE CASCADE
);
  
CREATE SEQUENCE fundit_contribution_seq;

CREATE OR REPLACE TRIGGER fundit_contribution_bir
BEFORE INSERT ON fundit_contribution
FOR EACH ROW

BEGIN
  SELECT fundit_contribution_seq.NEXTVAL
  INTO :new.id
  FROM dual;
END;
/
