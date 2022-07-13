<?php

namespace CMW\Entity\Redirect;


class RedirectEntity
{
    private ?int $id;
    private string $name;
    private string $slug;
    private string $target;
    private int $click;
    private int $isDefine;
    private int $totalClicks;

    /**
     * @param int|null $id
     * @param string $name
     * @param string $slug
     * @param string $target
     * @param int $click
     * @param int $isDefine
     * @param int $totalClicks
     */
    public function __construct(?int $id, string $name, string $slug, string $target, int $click, int $isDefine, int $totalClicks)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->target = $target;
        $this->click = $click;
        $this->isDefine = $isDefine;
        $this->totalClicks = $totalClicks;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return int
     */
    public function getClick(): int
    {
        return $this->click;
    }

    /**
     * @return int
     */
    public function getIsDefine(): int
    {
        return $this->isDefine;
    }

    /**
     * @return int
     */
    public function getTotalClicks(): int
    {
        return $this->totalClicks;
    }


}