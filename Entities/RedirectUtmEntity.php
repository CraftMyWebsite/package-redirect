<?php

namespace CMW\Entity\Redirect;

use CMW\Manager\Package\AbstractEntity;

/**
 * Class: @RedirectUtmEntity
 * @package Redirect
 * @link https://craftmywebsite.fr/docs/fr/technical/creer-un-package/entities
 */
class RedirectUtmEntity extends AbstractEntity
{
    private int $id;
    private int $logId;
    private string $key;
    private string $value;

    /**
     * @param int $id
     * @param int $logId
     * @param string $key
     * @param string $value
     */
    public function __construct(int $id, int $logId, string $key, string $value)
    {
        $this->id = $id;
        $this->logId = $logId;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLogId(): int
    {
        return $this->logId;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
