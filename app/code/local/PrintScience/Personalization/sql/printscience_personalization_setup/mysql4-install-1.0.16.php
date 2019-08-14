<?php
$installer = $this;
$installer->installEntities();

$installer->run("
	ALTER TABLE {$this->getTable('sales/quote_item')}   ADD  `personalization_info` TEXT NULL
");

$installer->startSetup();
$installer->updateAttribute('catalog_product', 'personalization_template_id', 'apply_to', implode(',',array('simple','bundle')));
$installer->updateAttribute('catalog_product', 'personalization_enabled', 'apply_to', implode(',',array('simple','bundle')));
$installer->endSetup();