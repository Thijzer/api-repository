<?php

namespace ApiRepo\Domain\Model;

interface EntityModel
{
    public function getIdentifier(): string;

    public function getData(): array;
}