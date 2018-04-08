<?php

namespace Sam\Events\TimeResolver;

interface TimeResolver
{
    public function resolve() : \DateTimeInterface;
}
