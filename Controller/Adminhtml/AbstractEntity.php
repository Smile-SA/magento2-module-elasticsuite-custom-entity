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

/**
 * Custom entity attribute set admin abstract controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
abstract class AbstractEntity extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::entity';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * @var Entity\Builder
     */
    protected $entityBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context                Context.
     * @param \Magento\Framework\View\Result\PageFactory       $pageFactory            Layout page factory.
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Entity\Builder $entityBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        parent::__construct($context);

        $this->entityBuilder = $entityBuilder;
        $this->pageFactory   = $pageFactory;
        $this->storeManager  = $storeManager;
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

        $resultPage->addBreadcrumb(__('Manage Custom Entities'), __('Manage Custom Entities'))
            ->setActiveMenu('Smile_ElasticsuiteCustomEntity::entity');

        $resultPage->getConfig()->getTitle()->prepend(__('Custom Entities'));

        if (!empty($title)) {
            $resultPage->addBreadcrumb($title, $title);
            $resultPage->getConfig()->getTitle()->prepend($title);
        }

        return $resultPage;
    }

    protected function getEntity()
    {
        return $this->entityBuilder->build($this->getRequest());
    }

    protected function getEntityId()
    {
        return (int) $this->getRequest()->getParam('id');
    }


    protected function getStoreId()
    {
        $storeId = $this->getRequest()->getParam('store', 0);
        $store   = $this->storeManager->getStore($storeId);
        $this->storeManager->setCurrentStore($store->getCode());

        return $storeId;
    }
}
