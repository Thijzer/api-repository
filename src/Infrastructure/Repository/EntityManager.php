<?php

namespace ApiRepo\Infrastructure\Repository;

use Akeneo\Pim\ApiClient\Pagination\ResourceCursorInterface;
use ApiRepo\Domain\Model\EntityModel;
use ApiRepo\Infrastructre\AkeneoApi\AkeneoApiClient;

class EntityManager
{
    private const PAGE_COUNT = 100;

    /** @var AkeneoApiClient */
    private $_client;
    private $_objectFactory;
    private $fqcn;
    private $cachedEntityLayer;

    public function __construct(AkeneoApiClient $client, CachedEntityLayer $cachedEntityLayer, $fqcn, $objectFactory)
    {
        $this->_client = $client;
        $this->_objectFactory = $objectFactory;
        // setup a unit a work with batch size
        $this->fqcn = $fqcn;
        $this->cachedEntityLayer = $cachedEntityLayer;
    }

    public function reCreateFromClass($fqcn): self
    {
        return new self($this->_client, $this->cachedEntityLayer, $fqcn, $this->_objectFactory);
    }

    public function get(string $identifier): array
    {
        return $this->_client->getProductApi()->get($identifier);
    }

    public function all(): ResourceCursorInterface
    {
        return $this->_client->getProductApi()->all(self::PAGE_COUNT);
    }

    public function find($criteria): ResourceCursorInterface
    {
        return $this->_client->getProductApi()->all(self::PAGE_COUNT, $criteria);
    }

    public function persist(EntityModel $entity): void
    {
        $this->_client->getProductApi()->upsert($entity->getIdentifier(), $entity->getData());
    }

    public function remove(EntityModel $entity): void
    {
        $this->_client->getProductApi()->delete($entity->getIdentifier());
    }

    public function clear(): void
    {
        $this->_em->flush();
        // clear unit of work for products
    }

    public function flush(): void
    {
        $this->_em->flush();
        // persist unit of work
    }

    public function __destruct()
    {
        $this->_em->flush();
        $this->flush();
    }
}