<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\DirectiveMultiParams;

class DirectiveMultiParamsTest extends BaseTestCase
{
    /**
     * @dataProvider providerToString
     * @param bool $canBeEmpty
     */
    public function testToString(bool $canBeEmpty): void
    {
        $directive = new class ('index.php', $canBeEmpty) extends DirectiveMultiParams
        {
            public function __construct(array|int|string|null $value, bool $canBeEmpty)
            {
                $this->canBeEmpty = $canBeEmpty;
                parent::__construct($value);
            }

            protected string $name = 'index';
        };
        $directive->add(['index.html', 'index.htm']);
        $this->assertSame('index index.php index.html index.htm;', (string)$directive);
        $directive->set([]);
        if ($canBeEmpty) {
            $this->assertSame('index;', (string)$directive);
        } else {
            $this->assertSame('', (string)$directive);
        }
    }

    public static function providerToString(): array
    {
        return [
            'yes' => [true],
            'no' => [false],
        ];
    }
}
