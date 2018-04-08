<?php

namespace Sam\Events\EventSourcing;

interface Aggregate
{
    public function raisedEvents() : array;
}
