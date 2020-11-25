<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Websolute\WidgetGenerator\Model\TemplatesPool\TemplatesPool;

class Template implements OptionSourceInterface
{
    /**
     * @var TemplatesPool
     */
    private $templatesPool;

    /**
     * @param TemplatesPool $templatesPool
     */
    public function __construct(
        TemplatesPool $templatesPool
    ) {
        $this->templatesPool = $templatesPool;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $results = [];
        /** \Websolute\WidgetVideo\Model\Template $template */
        foreach ($this->templatesPool->getList() as $template) {
            $results[] = [
                'value' => $template->getIdentifier(),
                'label' => $template->getTitle()
            ];
        }

        return $results;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $results = [];
        foreach ($this->templatesPool->getList() as $template) {
            $results[] = [
                $template['identifier'] => $template['title']
            ];
        }

        return $results;
    }
}
