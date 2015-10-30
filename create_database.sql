DROP TABLE fundit_contribution CASCADE CONSTRAINTS;
DROP TABLE fundit_project CASCADE CONSTRAINTS;
DROP TABLE fundit_user CASCADE CONSTRAINTS;
DROP TABLE fundit_roles CASCADE CONSTRAINTS;
DROP SEQUENCE fundit_contribution_seq;
DROP SEQUENCE fundit_project_seq;

CREATE TABLE fundit_roles (name VARCHAR(11) PRIMARY KEY);

CREATE TABLE fundit_user (
  username VARCHAR(20) PRIMARY KEY,
  roles VARCHAR(11) NOT NULL,
  name VARCHAR(32) NOT NULL,
  email VARCHAR(32) NOT NULL UNIQUE,
  password VARCHAR(32) NOT NULL,
  FOREIGN KEY (roles) REFERENCES fundit_roles(name) ON DELETE CASCADE
);

CREATE TABLE fundit_project (
  id INT PRIMARY KEY,
  owner_id VARCHAR(20) NOT NULL,
  title VARCHAR(64) NOT NULL,
  description VARCHAR(64) NOT NULL,
  goal REAL NOT NULL,
  deadline TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES fundit_user(username) ON DELETE CASCADE
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
  contributor_id VARCHAR(20) NOT NULL,
  project_id INT NOT NULL,
  amount REAL NOT NULL,
  FOREIGN KEY (contributor_id) REFERENCES fundit_user(username) ON DELETE CASCADE,
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

INSERT INTO fundit_roles VALUES('admin');
INSERT INTO fundit_roles VALUES('contributor');
INSERT INTO fundit_roles VALUES('creator');
--INSERT INTO fundit_user (name, roles, email, password) VALUES('budi', 'admin', 'budi@anduk.com', 'koyo');
--SELECT * FROM fundit_user WHERE name = 'budi';
--DELETE FROM fundit_user WHERE name = 'budi';
--SELECT fundit_user_seq.CURRVAL FROM dual;

