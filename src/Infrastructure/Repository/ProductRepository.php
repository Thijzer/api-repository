<?php

namespace ApiRepo\Infrastructure\Repository;

use Akeneo\Pim\ApiClient\Pagination\ResourceCursorInterface;
use ApiRepo\Domain\Model\Product;

class ProductRepository
{
    /** @var EntityManager */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em->reCreateFromClass(Product::class);
    }

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

    public function persist(Product $product): void
    {
        $this->em->persist($product);
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
    }
}