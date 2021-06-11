<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

class Comment
{
    public function __construct(private ?string $content = null)
    {
    }

    public function get(): ?string
    {
        return $this->content;
    }

    public function set(string|array|null $content): void
    {
        if (is_array($content)) {
            $content = implode("\n", $content);
        }
        $this->content = $content;
    }

    public function delete(): void
    {
        $this->set(null);
    }

    public function draw(string $block): string
    {
        $comment = (string)$this;
        if ($comment === '') {
            return $block;
        }
        if ($block === '') {
            return $comment;
        }
        return "$comment\n$block";
    }

    public function __toString(): string
    {
        if ($this->content === null) {
            return '';
        }
        return '# ' . str_replace("\n", "\n# ", $this->content);
    }
}
