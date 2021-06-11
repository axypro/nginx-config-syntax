<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\BaseContext;
use axy\nginx\config\syntax\Comment;

class BaseContextTest extends BaseTestCase
{
    public function testToString(): void
    {
        $context = new class () extends BaseContext
        {
            protected function getItems(): array
            {
                return [1, 2];
            }
        };
        $this->assertSame("1\n2", (string)$context);
        $context->comment->set('Test');
        $this->assertSame("# Test\n1\n2", (string)$context);
    }
}
