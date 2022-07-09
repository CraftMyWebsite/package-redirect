CREATE TABLE IF NOT EXISTS `cmw_redirect`
(
    `redirect_id`        int(11)         NOT NULL,
    `redirect_name`      varchar(255)    NOT NULL,
    `redirect_slug`      varchar(255)    NOT NULL,
    `redirect_target`    varchar(255)    NOT NULL,
    `redirect_click`     int(11)         NOT NULL DEFAULT '0',
    `redirect_is_define` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `cmw_redirect_logs`
(
    `redirect_logs_id`          int(11)   NOT NULL,
    `redirect_logs_redirect_id` int(11)            DEFAULT NULL,
    `redirect_logs_date`        timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    'redirect_logs_client_ip' varchar(39) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

ALTER TABLE `cmw_redirect`
    ADD PRIMARY KEY (`redirect_id`),
    ADD UNIQUE KEY `redirect_name` (`redirect_name`),
    ADD UNIQUE KEY `redirect_slug` (`redirect_slug`);

ALTER TABLE `cmw_redirect_logs`
    ADD PRIMARY KEY (`redirect_logs_id`),
    ADD KEY `redirect_logs_redirect_id` (`redirect_logs_redirect_id`);

ALTER TABLE `cmw_redirect`
    MODIFY `redirect_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cmw_redirect_logs`
    MODIFY `redirect_logs_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cmw_redirect_logs`
    ADD CONSTRAINT `cmw_redirect_logs_fk` FOREIGN KEY (`redirect_logs_redirect_id`) REFERENCES `cmw_redirect` (`redirect_id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;