<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Block\Widget;

use Exception;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use RuntimeException;
use Websolute\WidgetGenerator\Block\Widget;
use Websolute\WidgetGenerator\Model\TemplatesPool\TemplatesPoolInterface;

class Category extends Widget
{
    /**
     * @var CategoryInterface
     */
    private $category;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param Context $context
     * @param TemplatesPoolInterface $templatesPool
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        TemplatesPoolInterface $templatesPool,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        parent::__construct(
            $context,
            $templatesPool,
            $data
        );
    }

    /**
     * @return bool
     */
    public function hasCategory(): bool
    {
        if (!$this->category) {
            try {
                $this->loadCategory();
            } catch (Exception $e) {
                unset($e);
                return false;
            }
        }
        return true;
    }

    /**
     * @throws NoSuchEntityException
     */
    private function loadCategory(): void
    {
        $rewriteData = $this->parseIdPath((string)$this->getData('id_path'));
        $this->category = $this->categoryRepository->get($rewriteData[1]);
    }

    /**
     * @param string $idPath
     * @return array
     * @throws RuntimeException
     */
    private function parseIdPath(string $idPath)
    {
        $rewriteData = explode('/', $idPath);

        if (!isset($rewriteData[0]) || !isset($rewriteData[1])) {
            throw new RuntimeException('Wrong id_path structure.');
        }
        return $rewriteData;
    }

    /**
     * @return CategoryInterface
     * @throws NoSuchEntityException
     */
    public function getCategory(): CategoryInterface
    {
        if (!$this->category) {
            $this->loadCategory();
        }
        return $this->category;
    }
}
