CREATE DATABASE appchat;
\c appchat
grant all privileges on database appchat to postgres ;

CREATE TABLE chat (
  id SERIAL PRIMARY KEY,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  role SMALLINT,
  active boolean
);

INSERT INTO chat (username, password,role,active) VALUES (
  'user1',
  'pass1',
  1,
  't');
INSERT INTO chat (username, password,role,active) VALUES (
  'user2',
  'pass2',
  1,
  't');

  ALTER TABLE chat ADD COLUMN ROLE SMALLINT DEFAULT NULL;

   UPDATE chat SET role = 1 where id = 1;


INSERT INTO chat (username, password, role) VALUES (
  'user2',
  'pass2', 2);


ALTER TABLE chat ADD COLUMN active boolean DEFAULT NULL;
UPDATE chat SET active = true;
