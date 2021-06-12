<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class FixedDirective extends SingleDirective
{
    protected string $name;

    public function getName(): ?string
    {
        return $this->isCompleted() ? $this->name : null;
    }

    protected function isCompleted(): bool
    {
        return true;
    }
}
