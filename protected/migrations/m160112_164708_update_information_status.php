<?php

class m160112_164708_update_information_status extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{update_info}}', array(
			'id_update' => 'pk',
			'update_name' => 'varchar(50) DEFAULT NULL',
		  	'update_description' => 'text',
			'update_path'=>'varchar(250) DEFAULT NULL',
			'update_time_ins'=> 'datetime DEFAULT NULL',
			'update_version' => 'varchar(10) DEFAULT NULL',
			'update_custom' => "enum('0','1') NOT NULL DEFAULT '0'",
			'update_installed' => "enum('0','1') NOT NULL DEFAULT '0'",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('{{update_info}}');
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