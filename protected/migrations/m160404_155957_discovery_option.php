<?php

class m160404_155957_discovery_option extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{settings}}', 'discovery', "enum('0', '1') DEFAULT '0'");
		$this->addColumn('{{settings}}', 'default_building', 'int(10) unsigned DEFAULT NULL');
		$this->addColumn('{{settings}}', 'default_map', 'int(10) unsigned DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{settings}}', 'discovery');
		$this->dropColumn('{{settings}}', 'default_building');
		$this->dropColumn('{{settings}}', 'default_map');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}