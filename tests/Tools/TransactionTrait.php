<?php

declare(strict_types=1);

namespace App\Tests\Tools;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Трейт для использования транзакций при выполнении тестов.
 */
trait TransactionTrait
{
    use DITrait;

    protected EntityManagerInterface $entityManager;

    /**
     * Начать транзакцию.
     */
    protected function beginTransaction(): void
    {
        $this->entityManager = $this->getService(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();
    }

    /**
     * Откатить транзакцию.
     */
    protected function rollbackTransaction(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }
    }

    /**
     * Подтвердить транзакцию.
     */
    protected function commitTransaction(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->commit();
        }
    }
}
