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
  owner VARCHAR(20) NOT NULL,
  title VARCHAR(64) NOT NULL,
  description VARCHAR(1000) NOT NULL,
  goal REAL NOT NULL,
  deadline TIMESTAMP NOT NULL,
  category VARCHAR(32) NOT NULL,
  FOREIGN KEY (owner) REFERENCES fundit_user(username) ON DELETE CASCADE,
  FOREIGN KEY (category) REFERENCES fundit_category(category) ON DELETE CASCADE
  --CONSTRAINT project_creator CHECK (EXISTS (SELECT * FROM fundit_user fu WHERE fu.username = owner AND (fu.roles = 'creator' or fu.roles = 'admin')))
);

CREATE SEQUENCE fundit_project_seq;

CREATE TABLE fundit_contribution (
  id INT PRIMARY KEY,
  contributor VARCHAR(20) NOT NULL,
  project_id INT NOT NULL,
  timestamp TIMESTAMP NOT NULL,
  amount REAL NOT NULL,
  message VARCHAR(140) NOT NULL,
  FOREIGN KEY (contributor) REFERENCES fundit_user(username) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES fundit_project(id) ON DELETE CASCADE,
  CONSTRAINT positive_amount CHECK (amount > 0.0)
);

CREATE SEQUENCE fundit_contribution_seq;

CREATE TABLE fundit_category ( category VARCHAR(32) PRIMARY KEY );

INSERT INTO fundit_roles VALUES('admin');
INSERT INTO fundit_roles VALUES('contributor');
INSERT INTO fundit_roles VALUES('creator');
--INSERT INTO fundit_user (name, roles, email, password) VALUES('budi', 'admin', 'budi@anduk.com', 'koyo');
--SELECT * FROM fundit_user WHERE name = 'budi';
--DELETE FROM fundit_user WHERE name = 'budi';
--SELECT fundit_user_seq.CURRVAL FROM dual;
INSERT INTO fundit_user (username, name, email, roles, password) VALUES ('budi', 'budi_bola', 'budi@bola.com', 'admin', '529ca8050a00180790cf88b63468826a');
INSERT INTO fundit_category VALUES ('Others');
INSERT INTO fundit_project (id, owner, title, description, goal, deadline, category) VALUES (1, 'budi', 'bolpen untuk irvin', 'beliin bolpen', 800, '31-OCT-15 02.23.04.000000000 AM', 'Others');
