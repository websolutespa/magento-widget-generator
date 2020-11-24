<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\TemplatesPool;

use InvalidArgumentException;
use Websolute\WidgetGenerator\Model\Template\Template;

class TemplatesPool implements TemplatesPoolInterface
{
    /**
     * @var array $templates
     */
    private $templates = [];

    /**
     * @param array $templateArray
     */
    public function __construct(
        array $templateArray = []
    ) {
        foreach ($templateArray as $template) {
            if (!$template instanceof Template) {
                throw new InvalidArgumentException(
                    "Templates should implement \Websolute\WidgetGenerator\Model\Template\Template"
                );
            }
        }
        $this->templates = $templateArray;
    }

    /**
     * @param string $identifier
     * @return Template
     */
    public function get(string $identifier): Template
    {
        /** @var Template $template */
        foreach ($this->getList() as $template) {
            if ($template->getIdentifier() === $identifier) {
                return $template;
            }
        }
        throw new InvalidArgumentException("Invalid identifier");
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->templates;
    }
}
