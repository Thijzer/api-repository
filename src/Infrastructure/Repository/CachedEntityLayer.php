<?php

namespace ApiRepo\Infrastructure\Repository;

use ApiRepo\Domain\Model\EntityModel;

class CachedEntityLayer
{
    public const FLUSH_COUNT = 100;

    private $layer;

    public function add(EntityModel $entity): void
    {
        $this->layer[get_class($entity)][$entity->getIdentifier()] = $entity;
    }

    public function get(string $className, $id)
    {
        return $this->layer[$className][$id] ?? null;
    }

    public function getFlushable(string $className)
    {
        return $this->layer[$className] ?? null;
    }

    public function shouldFlush(string $className): bool
    {
        return count($this->layer[$className] ?? []) >= self::FLUSH_COUNT;
    }
}