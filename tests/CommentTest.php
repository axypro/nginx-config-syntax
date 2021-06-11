<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax\tests;

use axy\nginx\config\syntax\Comment;

class CommentTest extends BaseTestCase
{
    public function testToString(): void
    {
        $comment = new Comment('this is comment');
        $this->assertSame('this is comment', $comment->get());
        $this->assertSame('# this is comment', (string)$comment);
        $comment->delete();
        $this->assertNull($comment->get());
        $this->assertSame('', (string)$comment);
        $comment->set('');
        $this->assertSame('# ', (string)$comment);
        $comment->set("Multiline \n\ncomment\n");
        $this->assertSame("# Multiline \n# \n# comment\n# ", (string)$comment);
    }
}
