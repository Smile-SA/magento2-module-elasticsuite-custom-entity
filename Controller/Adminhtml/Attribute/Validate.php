<?php
namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute;

use Magento\Framework\DataObject;
use Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute;
use Magento\Framework\Exception\NoSuchEntityException;

class Validate extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute
{

    const DEFAULT_MESSAGE_KEY = 'message';

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\View\Result\PageFactory $pageFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory $attributeFactory,
        \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface $attributeRepository,
        \Smile\ElasticsuiteCustomEntity\Helper\Data $customEntityHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context, $registry, $pageFactory, $eavConfig, $attributeFactory, $attributeRepository, $customEntityHelper);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $response = new DataObject();
        $response->setError(false);

        $response = $this->checkAttributeCode($response);

        return $this->resultJsonFactory->create()->setJsonData($response->toJson());
    }

    /**
      * Set message to response object
      *
      * @param DataObject $response
      * @param string[] $messages
      * @return DataObject
      */
    private function setMessageToResponse($response, $messages)
    {
        $messageKey = $this->getRequest()->getParam('message_key', static::DEFAULT_MESSAGE_KEY);
        if ($messageKey === static::DEFAULT_MESSAGE_KEY) {
            $messages = reset($messages);
        }

        return $response->setData($messageKey, $messages);
    }

    private function checkAttributeCode($response)
    {
        $attributeCode = $this->getRequest()->getParam('attribute_code');
        $frontendLabel = $this->getRequest()->getParam('frontend_label');
        $attributeCode = $attributeCode ?: $this->generateCode($frontendLabel[0]);
        $attributeId   = $this->getRequest()->getParam('attribute_id');

        try {
            $attribute = $this->attributeRepository->get($attributeCode);

            if ($attribute->getId() && !$attributeId) {
                $message = __('An attribute with this code already exists.');
                $this->setMessageToResponse($response, [$message]);
                $response->setError(true);
            }
        } catch (NoSuchEntityException $e) {
            ; // Do nothing since no attribute with the same attribute_code has been found.
        }

        return $response;
    }
}
