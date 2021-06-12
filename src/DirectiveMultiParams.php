<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class DirectiveMultiParams extends FixedDirective
{
    public array $value;

    protected bool $canBeEmpty = false;

    public function __construct(array|string|int|null $value)
    {
        $this->set($value);
        parent::__construct();
    }

    public function set(array|string|int|null $value): void
    {
        if (!is_array($value)) {
            if ($value !== null) {
                $value = [$value];
            } else {
                $value = [];
            }
        }
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->value = $value;
    }

    public function add(array|string|int|null $value): void
    {
        if (is_array($value)) {
            /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
            $this->value = array_merge($this->value, $value);
        } elseif ($value !== null) {
            $this->value[] = $value;
        }
    }

    public function getParams(): string|array|null
    {
        return $this->value;
    }

    protected function isCompleted(): bool
    {
        return ($this->canBeEmpty || (!empty($this->value)));
    }
}
