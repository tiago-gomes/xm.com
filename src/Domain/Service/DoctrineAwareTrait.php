<?php

namespace App\Domain\Service;

use Doctrine\ORM\EntityManagerInterface;

trait DoctrineAwareTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManagerInterface $em): self
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * @deprecated
     */
    public function persist($object): void
    {
        $this->entityManager->persist($object);
    }
    
    /**
     * @param null $object
     */
    protected function flush($object = null): void
    {
        $this->getEntityManager()->flush($object);
    }
}
