<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class Context extends BaseContext
{
    public array $items = [];

    public function append(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function single(string $name, string|array|null $params = []): CustomSingleDirective
    {
        $directive = new CustomSingleDirective($name, $params);
        $this->items[] = $directive;
        return $directive;
    }

    public function block(string $name, string|array|null $params = []): CustomBlockDirective
    {
        $directive = new CustomBlockDirective($name, $params);
        $this->items[] = $directive;
        return $directive;
    }

    protected function getItems(): array
    {
        return $this->items;
    }
}
