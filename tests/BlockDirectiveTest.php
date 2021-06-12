<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\BlockDirective;

class BlockDirectiveTest extends BaseTestCase
{
    public function testToString(): void
    {
        $directive = new class () extends BlockDirective
        {
            public function getName(): ?string
            {
                return 'test';
            }

            public function addToMain(mixed $item): void
            {
                $this->mainContext->append($item);
            }

            public function setMainComment(?string $comment): void
            {
                $this->mainContext->comment->set($comment);
            }
        };
        $directive->append('one');
        $directive->append('two');
        $directive->comment->set('Test');
        $directive->context->comment->set('Test context');
        $directive->topContext->append('In top');
        $directive->topContext->comment->set('Top');
        $directive->setMainComment('Main');
        $directive->addToMain('in main');
        $expected = implode("\n", [
            '# Test',
            'test {',
            "\t# Test context",
            "\t# Top",
            "\tIn top",
            "\t# Main",
            "\tin main",
            "\tone",
            "\ttwo",
            '}',
        ]);
        $this->assertSame($expected, (string)$directive);
    }

    public function testNoName(): void
    {
        $directive = new class () extends BlockDirective
        {
            public function getName(): ?string
            {
                return null;
            }
        };
        $directive->comment->set('Test');
        $directive->append('one');
        $this->assertSame('', (string)$directive);
    }
}
