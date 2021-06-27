CREATE TABLE `users`
(
    `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
    `username`      varchar(25)  NOT NULL,
    `password`      varchar(128) NOT NULL,
    `email`         varchar(60)  NOT NULL,
    `mfa_code`      varchar(100) NOT NULL DEFAULT 'NOT SET',
    `login_attempt` int(11) NOT NULL DEFAULT 0,
    `lock_date`     datetime              DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4

CREATE TABLE `password_reset`
(
    `id`    int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4