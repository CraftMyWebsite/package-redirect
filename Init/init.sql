CREATE TABLE IF NOT EXISTS `cmw_redirect`
(
    `id`        INT(11)         NOT NULL AUTO_INCREMENT,
    `name`      VARCHAR(255)    NOT NULL,
    `slug`      VARCHAR(255)    NOT NULL,
    `target`    VARCHAR(255)    NOT NULL,
    `click`     INT(11)         NOT NULL DEFAULT '0',
    `is_define` INT(1) UNSIGNED NOT NULL DEFAULT '1',
    `store_ip`  TINYINT(1)      NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `redirect_name` (`name`),
    UNIQUE KEY `redirect_slug` (`slug`)
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cmw_redirect_logs`
(
    `id`          INT(11)     NOT NULL AUTO_INCREMENT,
    `redirect_id` INT(11)              DEFAULT NULL,
    `date`        TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `client_ip`   VARCHAR(39) NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `redirect_id` (`redirect_id`),
    CONSTRAINT `cmw_redirect_logs_fk` FOREIGN KEY (`redirect_id`)
        REFERENCES `cmw_redirect` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cmw_redirect_logs_utm`
(
    `id`     INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `log_id` INT(11)      NOT NULL,
    `key`    VARCHAR(20)  NOT NULL,
    `value`  VARCHAR(255) NOT NULL,
    KEY `redirects_utm_log_id` (`log_id`),
    CONSTRAINT `cmw_redirects_utm_fk` FOREIGN KEY (`log_id`)
        REFERENCES `cmw_redirect_logs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
