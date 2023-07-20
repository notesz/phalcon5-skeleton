-- Create table 'queue'
CREATE TABLE `queue` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `task` varchar(100) NOT NULL,
    `data` longtext,
    `created_datetime` datetime NOT NULL,
    `timing_datetime` datetime NOT NULL,
    `run_datetime` datetime DEFAULT NULL,
    `status` varchar(10) NOT NULL,
    `counter` int(2) NOT NULL,
    `error_message` mediumtext NOT NULL,
    PRIMARY KEY (`id`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
