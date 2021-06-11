<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class BaseContext extends BaseItem
{
    abstract protected function getItems(): array;

    protected function draw(): ?string
    {
        return RenderHelper::render($this->getItems());
    }
}
