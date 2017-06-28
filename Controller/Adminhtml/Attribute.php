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
 * Custom entity attribute admin abstract controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
abstract class Attribute extends \Magento\Backend\App\Action
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::attributes_attributes';

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Backend\Model\View\Result\PageFactory
     */
    private $pageFactory;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory
     */
    private $attributeFactory;

    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Helper\Data
     */
    protected $customEntityHelper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\PageFactory $pageFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory $attributeFactory,
        \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface $attributeRepository,
        \Smile\ElasticsuiteCustomEntity\Helper\Data $customEntityHelper
    ) {
        parent::__construct($context);
        $this->registry            = $registry;
        $this->pageFactory         = $pageFactory;
        $this->eavConfig           = $eavConfig;
        $this->attributeFactory    = $attributeFactory;
        $this->attributeRepository = $attributeRepository;
        $this->customEntityHelper  = $customEntityHelper;

    }

    protected function getAttributeRepository()
    {
        return $this->getAttributeRepository();
    }

    protected function getAttribute()
    {
        $attribute = $this->registry->registry('entity_attribute');

        if ($attribute === null) {
            $entityTypeId = $this->eavConfig->getEntityType(CustomEntityAttributeInterface::ENTITY_TYPE_CODE)->getId();
            $attribute    = $this->attributeFactory->create();
            $attribute->setEntityTypeId($entityTypeId);
            $attributeId   = $this->getRequest()->getParam('attribute_id');

            if ($attributeId != null) {
                $attribute = $this->attributeRepository->get($attributeId);
            }

            $this->registry->register('entity_attribute', $attribute);
        }

        return $attribute;
    }

    /**
     *
     * @param string $label
     *
     * @return string
     */
    protected function generateCode($label)
    {
        return $this->customEntityHelper->generateAttributeCodeFromLabel($label);
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

        $resultPage->addBreadcrumb(__('Manage Custom Entities Attributes'), __('Manage Custom Entities Attributes'))
            ->setActiveMenu('Smile_ElasticsuiteCustomEntity::attributes_attributes');

        $resultPage->getConfig()->getTitle()->prepend(__('Custom Entities Attributes'));

        if (!empty($title)) {
            $resultPage->addBreadcrumb($title, $title);
            $resultPage->getConfig()->getTitle()->prepend($title);
        }

        return $resultPage;
    }

    protected function getRedirectError($message)
    {
        $this->messageManager->addErrorMessage($message);
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
