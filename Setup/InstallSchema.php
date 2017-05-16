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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Custom entity schema setup.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var \Smile\ScopedEav\Setup\SchemaSetupFactory
     */
    private $schemaSetupFactory;

    /**
     * Constructor.
     *
     * @param \Smile\ScopedEav\Setup\SchemaSetupFactory $schemaSetup Scoped EAV schema setup factory.
     */
    public function __construct(\Smile\ScopedEav\Setup\SchemaSetupFactory $schemaSetupFactory)
    {
        $this->schemaSetupFactory = $schemaSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // Start setup.
        $setup->startSetup();

        $schemaSetup = $this->schemaSetupFactory->create(['setup' => $setup]);
        $connection  = $setup->getConnection();
        $entityTable = 'smile_elasticsuite_custom_entity';

        // Create the custom entity main table.
        $table = $schemaSetup->getEntityTable($entityTable)->setComment('ElasticSuite Custom Entity Table');
        $connection->createTable($table);

        // Create the custom entity attribute backend tables (int, varchar, decimal, text and datetime).
        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, 'int')
            ->setComment('Custom Entity Backend Table (int).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4')
            ->setComment('Custom Entity Backend Table (decimal).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, 'varchar')
            ->setComment('Custom Entity Backend Table (varchar).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k')
            ->setComment('Custom Entity Backend Table (text).');
        $connection->createTable($table);

        $table = $schemaSetup->getEntityAttributeValueTable($entityTable, \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME)
            ->setComment('Custom Entity Backend Table (datetime).');
        $connection->createTable($table);

        // Create the custom entity website link table.
        $table = $schemaSetup->getEntityWebsiteTable($entityTable)
            ->setComment('Custom Entity To Website Linkage Table');
        $connection->createTable($table);

        // End setup.
         $setup->endSetup();
    }
}
