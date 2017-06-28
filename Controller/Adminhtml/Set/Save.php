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

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Set;

use Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractSet;

/**
 * Custom entity attribute set admin save controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Save extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractSet
{
    /**
     * @var \Magento\Framework\Filter\FilterManager
     */
    private $filterManager;

    /**
     * @var \Magento\Eav\Api\Data\AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Api\AttributeSetRepositoryInterface $attributeSetRepository,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Eav\Api\Data\AttributeSetInterfaceFactory $attributeSetFactory,
        \Magento\Framework\Filter\FilterManager $filterManager,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context, $registry, $eavConfig, $attributeSetRepository, $pageFactory);

        $this->attributeSetFactory = $attributeSetFactory;
        $this->filterManager       = $filterManager;
        $this->jsonHelper          = $jsonHelper;
        $this->resultJsonFactory   = $resultJsonFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        $hasError      = false;
        $isNewSet      = $this->getRequest()->getParam('gotoEdit', false) == '1';

        $attributeSet = $this->getAttributeSet();

        try {

            $attributeSet->setAttributeSetName($this->filterManager->stripTags($this->getRequest()->getParam('attribute_set_name')));

            if ($isNewSet === false) {
                $data = $this->jsonHelper->jsonDecode($this->getRequest()->getPost('data'));
                $data['attribute_set_name'] = $this->filterManager->stripTags($data['attribute_set_name']);
                $attributeSet->organizeData($data);
            }

            $attributeSet->validate();

            if ($isNewSet) {
                $attributeSet->save();
                $attributeSet->initFromSkeleton($this->getRequest()->getParam('skeleton_set'));
            }

            $attributeSet->save();
            $this->messageManager->addSuccess(__('You saved the attribute set.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
            $hasError = true;
        } catch (\Exception $e) {
            $this->messageManager->addException($e, $e->getMessage());
            $this->messageManager->addException($e, __('Something went wrong while saving the attribute set.'));
            $hasError = true;
        }

        $response = $hasError ? $this->getErrorResponse() : $this->getSuccessResponse();

        if ($isNewSet) {
            $response = $this->getNewAttributeSetResponse($attributeSet);
        }

        return $response;
    }

    private function getNewAttributeSetResponse($attributeSet)
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $resultRedirect->setPath('*/*/add');

        if ($attributeSet && $attributeSet->getId()) {
            $resultRedirect->setPath('*/*/edit', ['id' => $attributeSet->getId()]);
        }

        return $resultRedirect;
    }

    private function getSuccessResponse()
    {
        $response = ['error' => 0, 'url' => $this->getUrl('custom_entity/set/index')];

        return $this->resultJsonFactory->create()->setData($response);
    }

    private function getErrorResponse()
    {
        $layout = $this->getLayout();
        $layout->initMessages();
        $response = ['error' => 1, 'message' => $layout->getMessagesBlock()->getGroupedHtml()];

        return $this->resultJsonFactory->create()->setData($response);
    }

    /**
     * Retrieve current entity type id.
     *
     * @return int
     */
    private function getEntityTypeId()
    {
        if ($this->registry->registry('entityType') === null) {
            $this->setTypeId();
        }
        return $this->registry->registry('entityType');
    }

    private function getLayout()
    {
        return $this->pageFactory->create()->getLayout();
    }

    /**
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @return \Magento\Eav\Api\Data\AttributeSetInterface
     */
    private function getAttributeSet()
    {
        $entityTypeId = $this->getEntityTypeId();
        $attributeSet = $this->attributeSetFactory->create()->setEntityTypeId($entityTypeId);

        $attributeSetId = $this->getRequest()->getParam('id', false);

        if ($attributeSetId !== false) {
            $attributeSet = $this->attributeSetRepository->get($attributeSetId);
        }

        return $attributeSet;
    }
}
