<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class Context extends BaseContext
{
    public array $items = [];

    public function append(mixed $item): mixed
    {
        $this->items[] = $item;
        return $item;
    }

    public function single(string $name, string|array|null $params = []): CustomSingleDirective
    {
        return $this->append(new CustomSingleDirective($name, $params));
    }

    public function block(string $name, string|array|null $params = []): CustomBlockDirective
    {
        return $this->append(new CustomBlockDirective($name, $params));
    }

    protected function getItems(): array
    {
        return $this->items;
    }
}
