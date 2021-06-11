<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\CustomSingleDirective;

class CustomSingleDirectiveTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new CustomSingleDirective('test', ['one', 't wo']);
        $this->assertSame('test one t\ wo;', (string)$directive);
        $directive->params[] = 'three';
        $this->assertSame('test one t\ wo three;', (string)$directive);
        $directive->params = null;
        $directive->comment->set('Comment');
        $this->assertSame("# Comment\ntest;", (string)$directive);
    }
}
