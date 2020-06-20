<?php

namespace App\Domain\Service;

use Doctrine\ORM\EntityManagerInterface;

interface DoctrineAwareInterface
{
    public function getEntityManager(): EntityManagerInterface;

    public function setEntityManager(EntityManagerInterface $em);
}
