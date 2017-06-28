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

/**
 * Custom entity attribute set admin add controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Add extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractSet
{
    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        $this->setTypeId();

        return $this->createActionPage(__('New Attribute Set'));
    }
}
