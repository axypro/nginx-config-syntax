<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\SingleDirective;

class SingleDirectiveTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new class () extends SingleDirective
        {
            public array|string|null $params = null;

            public function getName(): string
            {
                return 'my_directive';
            }

            public function getParams(): string|array|null
            {
                return $this->params;
            }
        };

        $this->assertSame('my_directive;', (string)$directive);
        $directive->params = 'one two';
        $this->assertSame('my_directive one two;', (string)$directive);
        $directive->params = ['three', 'four'];
        $this->assertSame('my_directive three four;', (string)$directive);
        $directive->params = '0';
        $this->assertSame('my_directive 0;', (string)$directive);
    }
}
