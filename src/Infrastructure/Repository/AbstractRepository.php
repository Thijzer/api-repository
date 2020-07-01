<?php

namespace ApiRepo\Infrastructure\Repository;

use Akeneo\Pim\ApiClient\Pagination\ResourceCursorInterface;
use ApiRepo\Domain\Model\EntityModel;

abstract class AbstractRepository
{
    /** @var EntityManager */
    protected $em;

    public function get(string $identifier): array
    {
        return $this->em->get($identifier);
    }

    public function all(): ResourceCursorInterface
    {
        return $this->em->all();
    }

    public function find($criteria): ResourceCursorInterface
    {
        return $this->em->find($criteria);
    }

    public function persist(EntityModel $entity): void
    {
        $this->em->persist($entity);
    }

    public function remove(EntityModel $entity): void
    {
        $this->em->remove($entity);
    }
}