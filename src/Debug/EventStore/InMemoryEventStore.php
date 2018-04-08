<?php

namespace Sam\Events\Debug\EventStore;

use Sam\Events\TimeResolver\NativeTimeResolver;
use Sam\Events\TimeResolver\TimeResolver;
use Sam\Events\EventStore\EventStore;
use Sam\Events\EventStore\EventWithMetadata;
use Sam\Events\EventStore\EventMetadata;

class InMemoryEventStore implements EventStore
{
    private $timeResolver;
    private $streams = [];

    public function __construct(TimeResolver $timeResolver = null)
    {
        $this->timeResolver = $timeResolver ?: new NativeTimeResolver();
    }

    public function store(string $stream, $event)
    {
        if (!array_key_exists($stream, $this->streams)) {
            $this->streams[$stream] = [];
        }

        $this->streams[$stream][] = [
            'metadata' => new EventMetadata($this->timeResolver->resolve()),
            'event' => $event,
        ];
    }

    public function read(string $stream): array
    {
        return array_map(function (EventWithMetadata $eventWithMetadata) {
            return $eventWithMetadata->getEvent();
        }, $this->readWithMetadata($stream));
    }

    public function readWithMetadata(string $stream): array
    {
        if (!array_key_exists($stream, $this->streams)) {
            return [];
        }

        return array_map(function (array $row) {
            return new EventWithMetadata($row['metadata'], $row['event']);
        }, $this->streams[$stream]);
    }
}
