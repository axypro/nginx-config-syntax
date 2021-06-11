<?php

declare(strict_types=1);

namespace axy\nginx\config\syntax;

abstract class BaseDirective extends BaseItem
{
    abstract public function getName(): string;

    public function getParams(): string|array|null
    {
        return [];
    }

    protected function getPrefix(): string
    {
        $result = $this->getName();
        $params = $this->getParams();
        if (is_array($params)) {
            foreach ($params as &$p) {
                $p = RenderHelper::escapeParam($p);
            }
            unset($p);
            $params = implode(' ', $params);
        } else {
            $params = (string)$params;
        }
        $params = trim($params);
        if ($params !== '') {
            $result .= " $params";
        }
        return $result;
    }

    abstract protected function getSuffix(): string;

    protected function draw(): ?string
    {
        return implode('', [
            $this->getPrefix(),
            $this->getSuffix(),
        ]);
    }
}
