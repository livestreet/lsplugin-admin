CREATE TABLE `prefix_admin_users_ban` (

	`id` INT NOT NULL AUTO_INCREMENT,

	`block_type` INT NOT NULL,
	`user_id` INT(11),
	`ip` VARCHAR(40),
	`ip_start` VARCHAR(40),
	`ip_finish` VARCHAR(40),

	`time_type` INT NOT NULL,
	`date_start` DATETIME NOT NULL,
	`date_finish` DATETIME NOT NULL,

	`add_date` DATETIME NOT NULL,
	`edit_date` DATETIME NOT NULL,

	`reason_for_user` VARCHAR(1000),
	`comment` VARCHAR(500),
	
	PRIMARY KEY (`id`),
	INDEX `block_type` (`block_type` ASC),
	INDEX `user_id` (`user_id` DESC),
	INDEX `ip` (`ip` DESC),
	INDEX `ip_start` (`ip_start` DESC),
	INDEX `ip_finish` (`ip_finish` DESC),

	INDEX `time_type` (`time_type` DESC),
	INDEX `date_start` (`date_start` DESC),
	INDEX `date_finish` (`date_finish` DESC),

	INDEX `add_date` (`add_date` DESC),
	INDEX `edit_date` (`edit_date` DESC)
)

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
