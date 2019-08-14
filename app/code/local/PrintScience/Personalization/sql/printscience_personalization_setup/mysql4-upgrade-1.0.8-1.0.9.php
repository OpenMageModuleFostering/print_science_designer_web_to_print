<?php
$installer = $this;
$installer->startSetup();
$installer->updateAttribute('catalog_product', 'personalization_template_id', 'apply_to', implode(',',array('simple','configurable')));
$installer->updateAttribute('catalog_product', 'personalization_enabled', 'apply_to', implode(',',array('simple','configurable')));
$installer->endSetup();
