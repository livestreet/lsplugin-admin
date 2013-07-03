CREATE TABLE `prefix_storage` (

  `id` INT NOT NULL AUTO_INCREMENT,
  `skey` VARCHAR(50) NOT NULL,
  `svalue` LONGTEXT NOT NULL,
  `instance` VARCHAR(50) NOT NULL,
  
  PRIMARY KEY (`id`),
  UNIQUE `skey_instance` (`skey`, `instance`),
  INDEX `instance` (`instance` DESC)
  
)

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
