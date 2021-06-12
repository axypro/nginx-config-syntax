<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class BlockDirective extends BaseDirective
{
    public Context $context;
    public Context $topContext;
    protected Context $mainContext;

    public function __construct()
    {
        parent::__construct();
        $this->context = new DirectiveContext();
        $this->topContext = $this->context->append(new DirectiveContext());
        $this->mainContext = $this->context->append(new DirectiveContext());
    }

    public function append(mixed $item): mixed
    {
        return $this->context->append($item);
    }

    protected function getSuffix(): string
    {
        $content = (string)$this->context;
        if ($content !== '') {
            $content = RenderHelper::indent($content) . "\n";
        }
        return " {\n$content}";
    }
}
