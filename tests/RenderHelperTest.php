<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\RenderHelper;

class RenderHelperTest extends BaseTestCase
{
    /**
     * @dataProvider providerFormat
     * @param array $args
     * @param string $expected
     */
    public function testFormat(
        array $args,
        string $expected,
    ): void {
        $this->assertSame($expected, RenderHelper::format(...$args));
    }

    public function providerFormat(): array
    {
        $text = implode("\n", [
            '# Test config file',
            '  ',
            'one {   ',
            "\ttwo {",
            "\t\t# Three",
            "\t\tthree;  ",
            "\t}",
            '}',
            '',
            '',
        ]);
        return [
            'trim' => [
                [
                    'text' => $text,
                    'indent' => '  ',
                ],
                implode("\n", [
                    '# Test config file',
                    '',
                    'one {',
                    "  two {",
                    "    # Three",
                    '    three;',
                    "  }",
                    '}',
                    '',
                ]),
            ],
            'clear' => [
                [
                    'text' => $text,
                    'indent' => ' ',
                    'clear' => true,
                    'nl' => "\r\n",
                ],
                implode("\r\n", [
                    'one {',
                    " two {",
                    '  three;',
                    " }",
                    '}',
                    '',
                ]),
            ],
        ];
    }

    public function testIndent(): void
    {
        $text = implode("\n", [
            'one {',
            "\ttwo { ",
            "\t\tthree",
            "\t}",
            '}',
            '',
        ]);
        $expected = implode("\n", [
            "\tone {",
            "\t\ttwo { ",
            "\t\t\tthree",
            "\t\t}",
            "\t}",
            "\t"
        ]);
        $this->assertSame($expected, RenderHelper::indent($text));
    }

    public function testRender(): void
    {
        $items = [
            'One',
            2,
            '',
            new class ()
            {
                public function __toString(): string
                {
                    return "first \n\nsecond\n\n";
                }
            },
            'A',
            new class ()
            {
                public function __toString(): string
                {
                    return '';
                }
            },
            'B',
            '',
        ];
        $expected = implode("\n", [
            'One',
            '2',
            '',
            'first ',
            '',
            'second',
            '',
            '',
            'A',
            'B',
            '',
        ]);
        $this->assertSame($expected, RenderHelper::render($items));
    }

    /**
     * @dataProvider providerEscapeParam
     * @param mixed $param
     * @param string $expected
     */
    public function testEscapeParam(mixed $param, string $expected): void
    {
        $this->assertSame($expected, RenderHelper::escapeParam($param));
    }

    /**
     * @return array
     */
    public function providerEscapeParam(): array
    {
        return [
            ['string', 'string'],
            [123, '123'],
            [null, ''],
            ['~кириллица', '~кириллица'],
            ['"string with spaces"', '\"string\ with\ spaces\"'],
        ];
    }
}
