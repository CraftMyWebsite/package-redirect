CREATE TABLE IF NOT EXISTS `cmw_redirect`
(
    `redirect_id`        INT(11)         NOT NULL AUTO_INCREMENT,
    `redirect_name`      VARCHAR(255)    NOT NULL,
    `redirect_slug`      VARCHAR(255)    NOT NULL,
    `redirect_target`    VARCHAR(255)    NOT NULL,
    `redirect_click`     INT(11)         NOT NULL DEFAULT '0',
    `redirect_is_define` INT(1) UNSIGNED NOT NULL DEFAULT '1',
    `redirect_store_ip`  TINYINT(1)      NOT NULL DEFAULT '1',
    PRIMARY KEY (`redirect_id`),
    UNIQUE KEY `redirect_name` (`redirect_name`),
    UNIQUE KEY `redirect_slug` (`redirect_slug`)
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cmw_redirect_logs`
(
    `redirect_logs_id`          INT(11)     NOT NULL AUTO_INCREMENT,
    `redirect_logs_redirect_id` INT(11)              DEFAULT NULL,
    `redirect_logs_date`        TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `redirect_logs_client_ip`   VARCHAR(39) NULL     DEFAULT NULL,
    PRIMARY KEY (`redirect_logs_id`),
    KEY `redirect_logs_redirect_id` (`redirect_logs_redirect_id`),
    CONSTRAINT `cmw_redirect_logs_fk` FOREIGN KEY (`redirect_logs_redirect_id`) REFERENCES `cmw_redirect` (`redirect_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
