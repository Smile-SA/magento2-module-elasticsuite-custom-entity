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

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

/**
 * Custom entity admin list controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Index extends \Smile\ScopedEav\Controller\Adminhtml\AbstractEntity
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::entity';

    /**
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        return $this->createActionPage(__('Custom Entities'));
    }
}
