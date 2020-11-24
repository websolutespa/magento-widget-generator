<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\Config\Source;

use Magento\Catalog\Helper\Product\ProductList;
use Magento\Framework\Data\OptionSourceInterface;

class ViewMode implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => ProductList::VIEW_MODE_LIST, 'label' => __('List')],
            ['value' => ProductList::VIEW_MODE_GRID, 'label' => __('Grid')]
        ];
    }
}
