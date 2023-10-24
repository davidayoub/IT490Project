CREATE TABLE `testdb`.`students` (
    `name` VARCHAR(255),
    `gpa` FLOAT,
    `year` INT,
    `ucid` INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`ucid`)
);