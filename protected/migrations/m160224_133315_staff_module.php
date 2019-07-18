<?php

class m160224_133315_staff_module extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{staff}}', array(
			'id_staff' => 'pk',
			'first_name' => 'varchar(100) DEFAULT NULL',
			'last_name' => 'varchar(100) DEFAULT NULL',
			'birth_day' => 'date DEFAULT NULL',
			'avatar_path'=>'varchar(250) DEFAULT NULL',
			'position' => 'varchar(150) DEFAULT NULL',
			'description' => 'text',
			'personal_id' => 'varchar(30) DEFAULT NULL',
			'pin_code' => 'varchar(30) DEFAULT NULL',
			'staff_status' => "enum('0','1') NOT NULL DEFAULT '0'",
			'id_building' => "int(10) unsigned NOT NULL"
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('{{staff_notes}}', array(
			'id_note_staff' => 'pk',
			'id_staff' => 'int(10) NOT NULL',
			'notes' => 'text',
			'file_url'=>'varchar(250) DEFAULT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('{{extension_inventory}}', array(
			'id_extension' => 'pk',
			'id_building' => "int(10) unsigned NOT NULL",
			'id_map' => "int(10) unsigned NOT NULL",
			'id_sip_server' => "int(10) unsigned NOT NULL",
			'ext_number' => 'varchar(10) DEFAULT NULL',
			'password' => 'varchar(100) DEFAULT NULL',
			'caller_id_internal' => 'varchar(100) DEFAULT NULL',
			'caller_id_external'=>'varchar(100) DEFAULT NULL',
			'caller_id_name' => 'varchar(100) DEFAULT NULL',
			'extension_define' => "enum('0','1') NOT NULL DEFAULT '0'",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('{{staff_working}}', array(
			'id_staff_working' => 'pk',
			'id_staff' => "int(10) unsigned NOT NULL",
			'id_extension' => "int(10) unsigned NOT NULL",
			'selected_rooms' => 'varchar(250) DEFAULT NULL',
			'start_work'=>'datetime NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('{{staff}}');
		$this->dropTable('{{staff_notes}}');
		$this->dropTable('{{extension_inventory}}');
		$this->dropTable('{{staff_working}}');
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