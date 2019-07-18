<?php

class m150609_180937_add_column_to_notification_pendant_log extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{notification_pendant_log}}', 'BaseName', "varchar(150) DEFAULT NULL");
		$this->addColumn('{{notification_pendant_log}}', 'DeviceType', "varchar(150) DEFAULT NULL");
	}

	public function down()
	{
		$this->dropColumn('{{notification_pendant_log}}', 'BaseName');
		$this->dropColumn('{{notification_pendant_log}}', 'DeviceType');
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