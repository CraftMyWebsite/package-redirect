<?php

namespace CMW\Entity\Redirect;

class RedirectLogsEntity
{
    private int $id;
    private ?int $redirectId;
    private string $date;
    private ?string $clientIp;

    /**
     * @param int $id
     * @param int|null $redirectId
     * @param string $date
     * @param string|null $clientIp
     */
    public function __construct(int $id, ?int $redirectId, string $date, ?string $clientIp)
    {
        $this->id = $id;
        $this->redirectId = $redirectId;
        $this->date = $date;
        $this->clientIp = $clientIp;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getRedirectId(): ?int
    {
        return $this->redirectId;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getClientIp(): ?string
    {
        return $this->clientIp;
    }
}
