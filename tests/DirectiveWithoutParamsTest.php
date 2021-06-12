<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\DirectiveWithoutParams;

class DirectiveWithoutParamsTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new class () extends DirectiveWithoutParams
        {
            protected string $name = 'internal';
        };
        $this->assertSame('internal;', (string)$directive);
        $directive->disable();
        $this->assertSame('', (string)$directive);
    }
}
