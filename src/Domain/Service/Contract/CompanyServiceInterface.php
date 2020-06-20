<?php

namespace App\Domain\Service\Contract;

/**
 * Interface CompanyServiceInterface
 * @package App\Domain\Service\Service\Contract
 */
interface CompanyServiceInterface
{
    /**
     * @param array $params
     * @return array|null
     */
    public function getAll(array $params): ?array;
}
