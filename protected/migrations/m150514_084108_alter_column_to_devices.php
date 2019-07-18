<?php

class m150514_084108_alter_column_to_devices extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{devices}}', 'device_classification', "enum('mialert','mipositioning') NOT NULL DEFAULT 'mialert' ");
		$this->dropForeignKey('FK_devices_id_room','{{devices}}');
		$this->dropIndex('FK_devices_id_room','{{devices}}');
		$this->alterColumn('{{devices}}', 'id_room', 'int(10) unsigned DEFAULT NULL');
	}

	public function down()
	{
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