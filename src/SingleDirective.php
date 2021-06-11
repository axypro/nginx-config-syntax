<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class SingleDirective extends BaseDirective
{
    protected function getSuffix(): string
    {
        return ';';
    }
}
