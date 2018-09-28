-- --------------------------------------------------------------------
-- MySQL eSessions table definition used in PHP DB_eSession Class.
--
-- Follow these MySQL Account Maintenance/phpMyAdmin steps:
-- 1) Create a database called 'db_esessions' or your choice.
-- 2) Create a username of 'sess_user' with password (i.e. 'sess1234').
-- 3) Give username created in step 2 (i.e. 'sess_user') access
--    privileges to database created in step 1 (i.e. 'db_esessions').
--    For security reasons, do NOT give the username all privileges.
--    Just give SELECT, INSERT, UPDATE, and DELETE privileges.
-- 4) Create the following table in the database created in step 1.
--
-- Note: If you think that you'll be storing more than 65,535
--       characters of session data, then change 'Text' to be
--       'MEDIUMTEXT' for the sess_value column. Remember, when
--       encrypting, length can be longer than plain text.
--       For security reasons, set the sess_sec_level default to 255,
--       and sess_locked to 1 (locked).
--       To save all tracing info. change sess_trace to VARCHAR(512)
--       or more. Some vers of MySQL/phpMyAdmin will change CHAR to
--       VARCHAR automatically, so just used VARCHAR here.
-- --------------------------------------------------------------------
drop table if exists eSessions;

CREATE TABLE eSessions (
  sess_id           VARCHAR(32) NOT NULL PRIMARY KEY,
  sess_sec_level    TINYINT(3)  UNSIGNED NOT NULL DEFAULT '255',
  sess_created      INT(11)     NOT NULL DEFAULT '0',
  sess_expiry       INT(11)     NOT NULL DEFAULT '0',
  sess_timeout      INT(11)     NOT NULL DEFAULT '0',
  sess_locked       bool        NOT NULL DEFAULT '1',
  sess_value        TEXT        NOT NULL DEFAULT '',
  sess_enc_iv       VARCHAR(32) NOT NULL DEFAULT '',
  sess_sec_id       VARCHAR(32) NOT NULL DEFAULT '',
  sess_trace        TINYTEXT    NOT NULL DEFAULT ''
)
TYPE=MyISAM
COMMENT = 'This table stores PHP session data';
