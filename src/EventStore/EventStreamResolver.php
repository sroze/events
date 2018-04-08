<?php

namespace Sam\Events\EventStore;

interface EventStreamResolver
{
    /**
     * @param mixed $event
     *
     * @return string|null
     */
    public function streamByEvent($event);
}
