<?php
$installer = $this;
$installer->installEntities();

if (!$installer->getConnection()->fetchOne("SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME = '{$this->getTable('sales/quote_item')}' AND COLUMN_NAME = 'personalization_info'")) {
    $installer->run("
        ALTER TABLE {$this->getTable('sales/quote_item')} ADD `personalization_info` TEXT NULL
    ");
}

$installer->startSetup();

$installer->addAttribute('catalog_product', 'personalization_product_id', array(
	'group'             => 'Personalization',
	'type'              => 'varchar',
	'backend'           => '',
	'frontend'          => '',
	'label'             => 'Template ID',
	'input'             => 'text',
	'class'             => '',
	'source'            => '',
	'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'visible'           => true,
	'required'          => false,
	'user_defined'      => false,
	'default'           => '',
	'searchable'        => false,
	'filterable'        => false,
	'comparable'        => false,
	'visible_on_front'  => false,
	'unique'            => false,
	'apply_to'          => implode(',',array('simple','configurable','bundle')),
	
));
$installer->updateAttribute('catalog_product', 'personalization_template_id', 'apply_to', implode(',',array('simple','configurable','bundle')));
$installer->updateAttribute('catalog_product', 'personalization_enabled', 'apply_to', implode(',',array('simple','configurable','bundle')));
$installer->endSetup();