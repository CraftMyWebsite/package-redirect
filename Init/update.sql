/* UPDATE FILE FOR PACKAGE REDIRECT 1.0.0 => 1.1.0 */

ALTER TABLE `cmw_redirect`
    RENAME COLUMN `redirect_id` to `id`,
    RENAME COLUMN `redirect_name` to `name`,
    RENAME COLUMN `redirect_slug` to `slug`,
    RENAME COLUMN `redirect_target` to `target`,
    RENAME COLUMN `redirect_click` to `click`,
    RENAME COLUMN `redirect_is_define` to `is_define`,
    RENAME COLUMN `redirect_store_ip` to `store_ip`;

ALTER TABLE `cmw_redirect_logs`
    RENAME COLUMN `redirect_logs_id` to `id`,
    RENAME COLUMN `redirect_logs_redirect_id` to `redirect_id`,
    RENAME COLUMN `redirect_logs_date` to `date`,
    RENAME COLUMN `redirect_logs_client_ip` to `client_ip`;

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
