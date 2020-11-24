<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Visibility implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => \Websolute\WidgetGenerator\Model\Visibility::MOBILE, 'label' => __('Mobile')],
            ['value' => \Websolute\WidgetGenerator\Model\Visibility::TABLET, 'label' => __('Tablet')],
            ['value' => \Websolute\WidgetGenerator\Model\Visibility::DESKTOP, 'label' => __('Desktop')]
        ];
    }
}
