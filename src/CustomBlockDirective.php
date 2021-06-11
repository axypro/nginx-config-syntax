<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class CustomBlockDirective extends BlockDirective
{
    public function __construct(protected string $name, public array|string|null $params = [])
    {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParams(): string|array|null
    {
        return $this->params;
    }
}
