CREATE TABLE `prefix_admin_users_ban` (

	`id` 																					INT NOT NULL AUTO_INCREMENT,

	-- full ban or read only
	`restriction_type` 														TINYINT NOT NULL DEFAULT 1,

	-- user, ip or range of ips
	`block_type` 																	TINYINT NOT NULL,
	`user_id` 																		INT(11),
	`ip` 																					INT UNSIGNED,					-- todo: review for ipv6
	`ip_start` 																		INT UNSIGNED,
	`ip_finish` 																	INT UNSIGNED,

	-- permanent or period
	`time_type` 																	TINYINT NOT NULL,
	`date_start` 																	DATETIME NOT NULL,
	`date_finish` 																DATETIME NOT NULL,

	`add_date` 																		DATETIME NOT NULL,
	`edit_date` 																	DATETIME,

	`reason_for_user` 														VARCHAR(500),
	`comment` 																		VARCHAR(500),
	
	PRIMARY KEY 																	(`id`),

	INDEX `restriction_type` 											(`restriction_type` ASC),

	INDEX `block_type` 														(`block_type` ASC),
	INDEX `user_id` 															(`user_id` DESC),
	INDEX `ip` 																		(`ip` DESC),
	INDEX `ip_start` 															(`ip_start` DESC),
	INDEX `ip_finish` 														(`ip_finish` DESC),

	INDEX `time_type` 														(`time_type` DESC),
	INDEX `date_start` 														(`date_start` DESC),
	INDEX `date_finish` 													(`date_finish` DESC),

	INDEX `add_date` 															(`add_date` DESC),
	INDEX `edit_date` 														(`edit_date` DESC)
)

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
