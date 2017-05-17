CREATE TABLE `pomojira`.`cf_board_issues` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_key` VARCHAR(45) NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`));
