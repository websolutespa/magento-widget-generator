<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Model\Template;

class Template
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $extraClass;

    /**
     * @param string $template
     * @param string $title
     * @param string $identifier
     * @param string|null $extra_class
     */
    public function __construct(
        string $template,
        string $title,
        string $identifier,
        string $extra_class = null
    ) {
        $this->template = $template;
        $this->title = $title;
        $this->identifier = $identifier;
        $this->extraClass = $extra_class;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getExtraClass(): string
    {
        return $this->extraClass ? " " . $this->extraClass : "";
    }
}
