CREATE DATABASE appchat;
\c appchat
grant all privileges on database appchat to postgres ;

CREATE TABLE chat (
  id SERIAL PRIMARY KEY,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
);

INSERT INTO chat (username, password) VALUES (
  'user1',
  'pass1');