CREATE TABLE `prefix_storage`(

	`id` 															INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`key` 														VARCHAR(50) NOT NULL,
	`value` 													MEDIUMTEXT NOT NULL,
	`instance` 												VARCHAR(50) NOT NULL,
	
	PRIMARY KEY												(`id`),
	UNIQUE `key_instance`							(`key`, `instance`),
	INDEX `key`												(`key` DESC),
	INDEX `instance`									(`instance` DESC)
	
)

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
