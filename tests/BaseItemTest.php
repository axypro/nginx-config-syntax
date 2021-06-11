<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\BaseItem;

class BaseItemTest extends BaseTestCase
{
    public function testRender(): void
    {
        $item = new class () extends BaseItem {
            protected function draw(): ?string
            {
                return "one  \n\ttwo  ";
            }
        };
        $this->assertTrue($item->isEnabled());
        $this->assertSame("one\n    two\n", $item->render());
        $this->assertSame("one  \n\ttwo  ", (string)$item);
        $item->disable();
        $this->assertFalse($item->isEnabled());
        $this->assertSame('', (string)$item);
        $item->enable();
        $this->assertTrue($item->isEnabled());
        $this->assertSame("one  \n\ttwo  ", (string)$item);
    }
}
