<?php

class m151126_083720_cdr_collect extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{cdr_collect}}', array(
			"id" => 'pk',
			"sys" => 'VARCHAR(16)',
			"primarycallid" => 'VARCHAR(255)',
			"callid" => 'VARCHAR(255)',
			"cid_from" => 'VARCHAR(255)',
			"cid_to" => 'VARCHAR(255)',
			"direction" => 'VARCHAR(4)',
			"remoteparty" => 'VARCHAR(255)',
			"localparty" => 'VARCHAR(255)',
			"trunkname" => 'VARCHAR(255)',
			"trunkid" => 'int(10)',
			"cost" => 'VARCHAR(10)',
			"cmc" => 'VARCHAR(20)',
			"domain" => 'VARCHAR(255)',
			"timestart" => 'DATETIME',
			"timeconnected" => 'DATETIME',
			"timeend" => 'DATETIME',
			"ltime" => 'DATETIME',
			"durationhhmmss" => 'VARCHAR(10)',
			"duration" => 'int(10)',
			"recordlocation" => 'VARCHAR(255)',
			"type" => 'VARCHAR(10)',
			"extension" => 'VARCHAR(255)',
			"idleduration" => 'int(10)',
			"ringduration" => 'int(10)',
			"holdduration" => 'int(10)',
			"ivrduration" => 'int(10)',
			"accountnumber" => 'VARCHAR(20)', // Assuming extensions are never longer than 20 characters
			"ipadr" => 'VARCHAR(40)'
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('{{cdr_collect}}');
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