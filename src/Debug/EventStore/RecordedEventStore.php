<?php

namespace Sam\Events\Debug\EventStore;

use Sam\Events\EventStore\EventStore;

class RecordedEventStore implements EventStore
{
    private $decoratedStore;

    private $recordedEvents = [];

    public function __construct(EventStore $decoratedStore)
    {
        $this->decoratedStore = $decoratedStore;
    }

    /**
     * {@inheritdoc}
     */
    public function store(string $stream, $event)
    {
        $this->decoratedStore->store($stream, $event);

        $this->recordedEvents[] = ['stream' => $stream, 'event' => $event];
    }

    /**
     * {@inheritdoc}
     */
    public function read(string $stream) : array
    {
        return $this->decoratedStore->read($stream);
    }

    /**
     * {@inheritdoc}
     */
    public function readWithMetadata(string $stream) : array
    {
        return $this->decoratedStore->readWithMetadata($stream);
    }

    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }
}
