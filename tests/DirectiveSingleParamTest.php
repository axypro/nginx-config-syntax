<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\DirectiveSingleParam;

class DirectiveSingleParamTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new class ('/var/www/html') extends DirectiveSingleParam
        {
            protected string $name = 'root';
        };
        $this->assertSame('root /var/www/html;', (string)$directive);
        $directive->set(null);
        $this->assertSame('', (string)$directive);
    }
}
