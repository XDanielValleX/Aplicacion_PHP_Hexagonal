<?php

declare(strict_types=1);

namespace App\Domain\Events;

abstract class DomainEvent
{
    private string $eventName;
    private string $occurredOn;

    public function __construct(string $eventName, ?string $occurredOn = null)
    {
        $this->eventName = $eventName;
        $this->occurredOn = $occurredOn ?? date('c');
    }

    public function eventName(): string
    {
        return $this->eventName;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function payload(): array;
}
