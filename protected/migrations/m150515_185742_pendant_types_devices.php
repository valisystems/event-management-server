<?php

class m150515_185742_pendant_types_devices extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{pendant_type}}', array(
			'id_pendant_type' => 'pk',
			'description' => 'varchar(150) DEFAULT NULL',
			'script' => 'varchar(150) DEFAULT NULL',
			'priority' => 'tinyint(3) unsigned DEFAULT NULL',
			'color_hex' => 'varchar(10) DEFAULT NULL',
		), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('{{pendant_type}}');
	}

}