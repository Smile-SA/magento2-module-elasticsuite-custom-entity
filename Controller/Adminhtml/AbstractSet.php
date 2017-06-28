<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCustomEntity
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2017 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface;

/**
 * Custom entity attribute set admin abstract controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
abstract class AbstractSet extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::attributes_set';

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Eav\Api\AttributeSetRepositoryInterface
     */
    protected $attributeSetRepository;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * Constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context                Context.
     * @param \Magento\Framework\Registry                      $registry               Registry.
     * @param \Magento\Eav\Model\Config                        $eavConfig              EAV config.
     * @param \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSetRepository Attribute set repository.
     * @param \Magento\Framework\View\Result\PageFactory       $pageFactory            Layout page factory.
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSetRepository,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->registry               = $registry;
        $this->eavConfig              = $eavConfig;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->pageFactory            = $pageFactory;
    }

    /**
     * Define in register catalog_product entity type code as entityType
     *
     * @return void
     */
    protected function setTypeId()
    {
        $entityType = $this->eavConfig->getEntityType(CustomEntityAttributeInterface::ENTITY_TYPE_CODE);
        $this->registry->register('entityType', $entityType->getId());

        return $this;
    }

    /**
     * Create the page.
     *
     * @param \Magento\Framework\Phrase|null $title Page title.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function createActionPage($title = null)
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create()->initLayout();

        $resultPage->addBreadcrumb(__('Manage Custom Entities Attribute Sets'), __('Manage Custom Entities Attributes Sets'))
            ->setActiveMenu('Smile_ElasticsuiteCustomEntity::attributes_set');

        $resultPage->getConfig()->getTitle()->prepend(__('Custom Entities Attribute Sets'));

        if (!empty($title)) {
            $resultPage->addBreadcrumb($title, $title);
            $resultPage->getConfig()->getTitle()->prepend($title);
        }

        return $resultPage;
    }
}
