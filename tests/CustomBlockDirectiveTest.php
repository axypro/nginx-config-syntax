<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\CustomBlockDirective;

class CustomBlockDirectiveTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new CustomBlockDirective('test', ['one']);
        $directive->comment->set('Comment');
        $directive->params[] = 'two';
        $nested = new CustomBlockDirective('nested', 'xx');
        $directive->append($nested);
        $nested->append('xxx');
        $expected = implode("\n", [
            '# Comment',
            'test one two {',
            "\tnested xx {",
            "\t\txxx",
            "\t}",
            '}',
        ]);
        $this->assertSame($expected, (string)$directive);
    }
}
