CREATE TABLE `SchoolSections` (
  `school_section_id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`school_section_id`)
);



INSERT INTO `akshara`.`SchoolSections` (`section`) VALUES ('Section A');
INSERT INTO `akshara`.`SchoolSections` (`section`) VALUES ('Section B');
INSERT INTO `akshara`.`SchoolSections` (`section`) VALUES ('Section C');
INSERT INTO `akshara`.`SchoolSections` (`section`) VALUES ('Section D');

Alter table SchoolUsers add column school_section_id int(11);


update SchoolUsers set school_section_id = 1 where school_section_id is null;

INSERT INTO `Classes` (`name`,`description`) VALUES ('Class VIII','Class VIII');
INSERT INTO `Classes` (`name`,`description`) VALUES ('Class X','Class X');
