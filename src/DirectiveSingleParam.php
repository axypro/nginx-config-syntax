<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class DirectiveSingleParam extends FixedDirective
{
    public function __construct(public string|int|null $value = null)
    {
        parent::__construct();
    }

    public function set(string|int|null $value): void
    {
        $this->value = $value;
    }

    public function getParams(): string|array|null
    {
        return [$this->value];
    }

    protected function isCompleted(): bool
    {
        return (($this->value !== null) && ($this->value !== ''));
    }
}
