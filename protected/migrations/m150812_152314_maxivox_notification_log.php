<?php

class m150812_152314_maxivox_notification_log extends CDbMigration
{
	public function up()
	{
		echo "Create Notification MaxiVox Log Table \n\r";
		//$this->dropTable('{{notification_pendant_log}}');
		$this->createTable('{{notification_maxivox_log}}', array(
			'id_log' => 'pk',
			'maxivox_address' => "varchar(18) DEFAULT NULL",
			'DeviceType' => "varchar(18) DEFAULT NULL",
			'DeviceLabel' => "varchar(50) DEFAULT NULL",
			'acknowledge' => "enum('0','1') DEFAULT NULL",
			'type_notification' => "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
			'receiver' => "varchar(250) DEFAULT NULL",
			'message_sent' => "text",
			'current_time' => "timestamp NULL DEFAULT CURRENT_TIMESTAMP",
			'response_message' => "text",
			'status_of_notification' => "enum('0','1') DEFAULT NULL",
			'time_stamp' => "timestamp NULL DEFAULT NULL",
			'device_description' => "varchar(250) DEFAULT NULL",
			'live_panel' => "enum('Y','N') DEFAULT 'Y'",
			'require_acknowledge' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close' => "enum('Y','N') DEFAULT 'Y'",
			'flashing_toggle' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close_duration' => "tinyint(3) unsigned DEFAULT NULL",
			'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'"
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		echo "Table Notification MaxiVox Log Created \n\r\n\r";
	}

	public function down()
	{
		echo "Delete Notification MaxiVox Log Table \n\r";
		$this->dropTable('{{notification_maxivox_log}}');
		echo "Notification MaxiVox Log Deleted \n\r\n\r";
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