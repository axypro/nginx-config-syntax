<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class CustomSingleDirective extends SingleDirective
{
    public function __construct(protected string $name, public string|array|null $params = [])
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
