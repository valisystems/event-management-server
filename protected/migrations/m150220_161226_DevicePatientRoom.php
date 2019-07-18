<?php

class m150220_161226_DevicePatientRoom extends CDbMigration
{
	/**
	 *
     */
	public function up()
	{
		//DROP INDEX FK_rdp_id_patient ON mialert.mia_room_device_patient;
		$this->dropForeignKey('FK_rdp_id_patient','{{room_device_patient}}');
	}

	public function down()
	{
		echo "m150220_161226_DevicePatientRoom does not support migration down.\n";
		return false;
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