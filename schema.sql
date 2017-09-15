CREATE DATABASE `schema`;
USE `schema`;

CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(64) NOT NULL,
	`register_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`email` VARCHAR(128) NOT NULL,
	`contacts` TEXT NOT NULL
);

CREATE TABLE `categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` CHAR(128),
	`user_id` INT(11) NOT NULL
);

CREATE TABLE `tasks` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(64) NOT NULL,
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`done` TIMESTAMP NULL DEFAULT NULL,
	`deadline` TIMESTAMP NULL DEFAULT NULL,
	`file` VARCHAR(128) NULL DEFAULT NULL,
	`user_id` INT(11) NOT NULL,
	`project_id` INT(11) NOT NULL
);

CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX project ON categories(name);
CREATE INDEX user ON tasks(user_id);
CREATE INDEX project_id ON tasks(project_id);