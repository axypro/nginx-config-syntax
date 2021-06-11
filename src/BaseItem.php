<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class BaseItem
{
    public Comment $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function isEnabled(): bool
    {
        return $this->amIEnabled;
    }

    public function enable(): void
    {
        $this->amIEnabled = true;
    }

    public function disable(): void
    {
        $this->amIEnabled = false;
    }

    public function __toString(): string
    {
        if (!$this->amIEnabled) {
            return '';
        }
        $result = (string)$this->draw();
        return $this->comment->draw($result);
    }

    /**
     * Renders the item
     * @see RenderHelper::format() for arguments
     *
     * @param string $indent
     * @param bool $clear
     * @param bool $rtrim
     * @param string $nl
     * @return string
     */
    public function render(
        string $indent = '    ',
        bool $clear = false,
        bool $rtrim = true,
        string $nl = "\n",
    ): string {
        return RenderHelper::format(
            text: (string)$this,
            indent: $indent,
            clear: $clear,
            rtrim: $rtrim,
            nl: $nl,
        );
    }

    abstract protected function draw(): ?string;

    private bool $amIEnabled = true;
}
