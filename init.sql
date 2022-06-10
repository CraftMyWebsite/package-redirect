CREATE TABLE `cmw_redirect`
(
    `id`        int(11)         NOT NULL,
    `name`      varchar(255)    NOT NULL,
    `slug`      varchar(255)    NOT NULL,
    `target`    varchar(255)    NOT NULL,
    `click`     int(11)         NOT NULL DEFAULT '0',
    `is_define` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `cmw_redirect_logs`
(
    `id`          int(11)   NOT NULL,
    `redirect_id` int(11)            DEFAULT NULL,
    `date`        timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = latin1;

ALTER TABLE `cmw_redirect`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`),
    ADD UNIQUE KEY `slug` (`slug`);

ALTER TABLE `cmw_redirect_logs`
    ADD PRIMARY KEY (`id`),
    ADD KEY `redirect_id` (`redirect_id`);

ALTER TABLE `cmw_redirect`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cmw_redirect_logs`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cmw_redirect_logs`
    ADD CONSTRAINT `cmw_redirect_logs_fk` FOREIGN KEY (`redirect_id`) REFERENCES `cmw_redirect` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;