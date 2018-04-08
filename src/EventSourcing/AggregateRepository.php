<?php

namespace Sam\Events\EventSourcing;

interface AggregateRepository
{
    /**
     * @param string $aggregateIdentifier
     *
     * @throws AggregateNotFound
     *
     * @return Aggregate
     */
    public function find(string $aggregateIdentifier) : Aggregate;
}
