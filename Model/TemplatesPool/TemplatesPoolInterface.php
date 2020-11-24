<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\TemplatesPool;

use Websolute\WidgetGenerator\Model\Template\Template;

interface TemplatesPoolInterface
{
    /**
     * @return array
     */
    public function getList();

    /**
     * @param string $identifier
     * @return Template
     */
    public function get(string $identifier): Template;
}
