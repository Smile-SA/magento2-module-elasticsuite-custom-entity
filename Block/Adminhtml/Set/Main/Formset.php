<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile Elastic Suite to newer
 * versions in the future.
 *
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCustomEntity
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2017 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Set\Main;

use Magento\Backend\Block\Widget\Form;

class Formset extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Set\Main\Formset
{
    /**
     * Prepares attribute set form
     *
     * @return void
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $this->getForm()->setAction($this->getUrl('custom_entity/set/save'));
    }
}
