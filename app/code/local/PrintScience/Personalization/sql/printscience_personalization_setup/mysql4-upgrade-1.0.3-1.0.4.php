<?php
$installer = $this;
$installer->run("
	ALTER TABLE {$this->getTable('sales/quote_item')}   ADD  `personalization_info` TEXT NULL
");
