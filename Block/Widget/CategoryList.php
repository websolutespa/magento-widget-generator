<?php
/**
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Websolute\WidgetGenerator\Block\Widget;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Framework\Exception\NoSuchEntityException;
use RuntimeException;
use Websolute\WidgetGenerator\Block\Widget;
use Websolute\WidgetGenerator\Model\TemplatesPool\TemplatesPoolInterface;

/**
 * Catalog Products List widget block
 * Class ProductsList
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CategoryList extends Widget
{
    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        Context $context,
        TemplatesPoolInterface $templatesPool,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $templatesPool,
            $data
        );
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function _beforeToHtml()
    {
        $this->setCategoryCollection($this->createCollection());
        return parent::_beforeToHtml();
    }

    /**
     * Prepare and return category collection
     *
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function createCollection()
    {
        $categoryId = $this->getIdFromIdPath((string)$this->getIdPath());

        /** @var Category $category */
        $category = $this->categoryRepository->get($categoryId);

        return $category->getChildrenCategories();
    }

    /**
     * @param string $idPath
     * @return string
     * @throws RuntimeException
     */
    protected function getIdFromIdPath(string $idPath)
    {
        $rewriteData = explode('/', $idPath);

        if (!isset($rewriteData[0]) || !isset($rewriteData[1])) {
            throw new RuntimeException('Wrong id_path structure.');
        }
        return $rewriteData[1];
    }
}
