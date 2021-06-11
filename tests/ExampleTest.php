<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\Context;

class ExampleTest extends BaseTestCase
{
    public function testToString(): void
    {
        $main = new Context();
        $main->comment->set([
            'The main context',
            'Comment line starts with "#"', 'Indents doesn\'t matter',
            'Empty strings doesn\'t matter',
        ]);

        $main->append('');
        $main->single('single_directive');
        $directive = $main->single('single_directive_with_parameters', ['one', 'two']);
        $directive->params[] = 'three';
        $main->append('');

        $block = $main->block('block_directive', ['param1', 'param2']);
        $block->context->single('nested_single_directive');
        $nested = $block->context->block('nested_block_directive');
        $nested->context->single('nested_nested_single_directive', 'param');
        $block->context->comment->set('Nested context');

        $expected = rtrim(file_get_contents(__DIR__ . '/example.txt')) . "\n";
        $this->assertSame($expected, $main->render());
    }
}
