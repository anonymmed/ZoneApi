<?php

namespace App\Entity;

trait TimeStamps
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @throws \Exception
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updatedAt()
    {
        $this->updated_at = new \DateTime();
    }
}
