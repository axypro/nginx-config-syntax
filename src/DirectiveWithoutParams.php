<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class DirectiveWithoutParams extends FixedDirective
{
    protected string $name;
}
