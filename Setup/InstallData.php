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

namespace Smile\ElasticsuiteCustomEntity\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * Custom entity EAV setup factory
     *
     * @var CustomEntitySetupFactory
     */
    private $customEntitySetupFactory;

    /**
     * Constructor.
     *
     * @param CustomEntitySetupFactory $customEntitySetupFactory Custom entity EAV setup factory.
     */
    public function __construct(CustomEntitySetupFactory $customEntitySetupFactory)
    {
        $this->customEntitySetupFactory = $customEntitySetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var CustomEntitySetup$categorySetup */
        $customEntitySetup = $this->customEntitySetupFactory->create(['setup' => $setup]);

        $customEntitySetup->installEntities();
    }
}
