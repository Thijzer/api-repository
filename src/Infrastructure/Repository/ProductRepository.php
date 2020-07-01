<?php

namespace ApiRepo\Infrastructure\Repository;

use ApiRepo\Domain\Model\Product;

class ProductRepository extends AbstractRepository
{
    /** @var EntityManager */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em->reCreateFromClass(Product::class);
    }
}