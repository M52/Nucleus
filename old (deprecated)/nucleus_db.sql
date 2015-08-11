CREATE DATABASE IF NOT EXISTS ndb;
USE ndb;

CREATE TABLE n_User
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(60) UNIQUE NOT NULL,
	password VARCHAR(200) NOT NULL,
	profile_name VARCHAR(60),
	profile_surname VARCHAR(60),
	gender_id INT(2) UNSIGNED NOT NULL
) Engine=InnoDB;

CREATE TABLE n_Gender
(
	gender_id INT(2) UNSIGNED PRIMARY KEY,
	gender VARCHAR(10) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO n_Gender (gender_id, gender) VALUES (0, "MALE");
INSERT INTO n_Gender (gender_id, gender) VALUES (1, "FEMALE");
INSERT INTO n_Gender (gender_id, gender) VALUES (2, "OTHER");

ALTER TABLE n_User 
ADD CONSTRAINT FK_gender
FOREIGN KEY (gender_id) REFERENCES n_Gender(gender_id)
ON UPDATE CASCADE
ON DELETE CASCADE;
#Select gender query: SELECT gender FROM `n_gender` WHERE ( SELECT gender_id FROM `n_user` WHERE id=1 ) = gender_id
#This table holds all the possible rights that can be granted to a User.
CREATE TABLE n_Rights
(
	right_id INT(6) UNSIGNED PRIMARY KEY,
	right_alias VARCHAR(20) NOT NULL UNIQUE
) Engine=InnoDB;

INSERT INTO n_Rights (right_id, right_alias) VALUES (0, "CREATE_ARTICLE");
INSERT INTO n_Rights (right_id, right_alias) VALUES (1, "EDIT_ARTICLE");
INSERT INTO n_Rights (right_id, right_alias) VALUES (2, "DELETE_ARTICLE");

CREATE TABLE n_UserRights
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT(6) UNSIGNED NOT NULL,
	right_id INT(6) UNSIGNED NOT NULL
) Engine=InnoDB;

#user_id must reference an existing user. If a user is removed, these rights are removed too.
ALTER TABLE n_UserRights
ADD CONSTRAINT FK_User
FOREIGN KEY (user_id) REFERENCES n_User(id)
ON UPDATE CASCADE
ON DELETE CASCADE;

ALTER TABLE n_UserRights
ADD CONSTRAINT FK_Right
FOREIGN KEY (right_id) REFERENCES n_Rights(right_id)
ON UPDATE CASCADE
ON DELETE CASCADE;

#CREATE TABLE n_Article
#(
#	article_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
#	header VARCHAR(100) NOT NULL,
#	body VARCHAR
#)