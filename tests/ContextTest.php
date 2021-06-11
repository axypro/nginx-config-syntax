<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\Context;

class ContextTest extends BaseTestCase
{
    public function testToString(): void
    {
        $context = new Context();
        $context->comment->set('Test');
        $context->append('String');
        $context->append('');
        $nested = new Context();
        $context->append($nested);
        $context->append(2);
        $nested->comment->set('Nested');
        $nested->append('Line');
        $expected = implode("\n", [
            '# Test',
            'String',
            '',
            '# Nested',
            'Line',
            '2',
        ]);
        $this->assertSame($expected, (string)$context);
    }
}
