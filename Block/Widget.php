<?php
/**
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Cms\Block\Block;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\Store;
use Magento\Widget\Block\BlockInterface;
use Websolute\WidgetGenerator\Model\Template\Template as WidgetGeneratorTemplate;
use Websolute\WidgetGenerator\Model\TemplatesPool\TemplatesPoolInterface;
use Websolute\WidgetGenerator\Model\Visibility;

class Widget extends Template implements BlockInterface
{
    /**
     * @var TemplatesPoolInterface
     */
    private $templatesPool;

    /**
     * @var WidgetGeneratorTemplate
     */
    private $templateFromPool;

    /**
     * @var string
     */
    private $mediaBaseUrl;

    /**
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * @param Context $context
     * @param TemplatesPoolInterface $templatesPool
     * @param DecoderInterface $decoder
     * @param array $data
     */
    public function __construct(
        Context $context,
        TemplatesPoolInterface $templatesPool,
        DecoderInterface $decoder,
        array $data = []
    ) {
        $this->templatesPool = $templatesPool;
        $this->decoder = $decoder;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getExtraClass(): string
    {
        $classes = $this->getTemplateIdentifier();
        $classes .= $this->templateFromPool->getExtraClass() ? $this->templateFromPool->getExtraClass() : '';
        $classes .= $this->getVisibilityClass() ? $this->getVisibilityClass() : '';
        return $classes;
    }

    /**
     * @return string
     */
    public function getTemplateIdentifier(): string
    {
        return $this->templateFromPool->getIdentifier();
    }

    /**
     * @return string
     */
    public function getVisibilityClass()
    {
        $visibilityClass = '';

        $visibility = $this->hasData('visibility') ?
            explode(',', $this->getData('visibility')) : false;

        if (is_array($visibility)) {
            $visibilityClass = ' widget-visibility';

            if (in_array(Visibility::MOBILE, $visibility)) {
                $visibilityClass .= ' widget-visible-mobile';
            }
            if (in_array(Visibility::TABLET, $visibility)) {
                $visibilityClass .= ' widget-visible-tablet';
            }
            if (in_array(Visibility::DESKTOP, $visibility)) {
                $visibilityClass .= ' widget-visible-desktop';
            }
        }

        return $visibilityClass;
    }

    /**
     * @param string $value
     * @return string
     */
    public function getImageUrl(string $value): string
    {
        if (strpos($value, '___directive') !== 0) {
            $url = strstr(
                substr($value, strpos($value, '___directive/') +
                    strlen('___directive/')),
                '/key',
                true
            );
            $url = $this->decoder->decode($url);

            if (false !== strpos($url, '{{media')) {
                $value = strstr(substr($url, strpos($url, '{{media url="') + strlen('{{media url="')), '"}}', true);
            }
        }

        /** @codingStandardsIgnoreStart */
        if (array_key_exists('scheme', parse_url($value))) {
            return $value;
        }
        /** @codingStandardsIgnoreEnd */

        return $this->getMediaBaseUrl() . $value;
    }

    /**
     * @return string
     */
    public function getMediaBaseUrl(): string
    {
        if ($this->mediaBaseUrl === null) {
            try {
                /** @var Store $store */
                $store = $this->_storeManager->getStore();
                $this->mediaBaseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            } catch (NoSuchEntityException $e) {
                unset($e);
            }
        }
        return $this->mediaBaseUrl;
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    public function htmlEntityDecode(string $value = null): ?string
    {
        if ($value === null) {
            return null;
        }
        /** @codingStandardsIgnoreStart */
        return html_entity_decode($value);
        /** @codingStandardsIgnoreEnd */
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->templateFromPool = $this->templatesPool->get($this->getData('template_name'));
        $this->setTemplate($this->templateFromPool->getTemplate());
        parent::_construct();
    }

    /**
     * @inheritdoc
     */
    protected function _prepareLayout()
    {
        if ($this->getCmsBlockIdentifier() !== '') {
            try {
                /** @var Block $block */
                $block = $this->getLayout()
                    ->createBlock(Block::class);
                $block->setData('block_id', $this->getCmsBlockIdentifier());
                $this->setChild('cms_block_element', $block);
            } catch (LocalizedException $e) {
                unset($e);
            }
        }
        return parent::_prepareLayout();
    }

    /**
     * Return the Cms Block identifier
     *
     * @return string
     */
    public function getCmsBlockIdentifier(): string
    {
        if ($this->hasData('cms_block_id')) {
            return $this->getData('cms_block_id');
        }
        return '';
    }
}
