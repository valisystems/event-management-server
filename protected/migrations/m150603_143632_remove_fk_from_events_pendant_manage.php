<?php

class m150603_143632_remove_fk_from_events_pendant_manage extends CDbMigration
{
	public function up()
	{
		//$this->dropForeignKey('FK_events_pendant_manage_id_device','{{events_pendant_manage}}');
		//$this->insert('{{users}}')

	}

	public function down()
	{
		//$this->addForeignKey('FK_events_pendant_manage_id_device', '{{events_pendant_manage}}', 'id_pendant_type', '{{pendant_type}}', 'id_pendant_type', 'CASCADE', 'CASCADE');
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