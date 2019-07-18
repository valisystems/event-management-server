<?php

class m150526_184332_add_new_type_events extends CDbMigration
{
	public function up()
	{
		//$this->dropTable('{{global_event_pendant_template}}');
		//$this->dropTable('{{notification_pendant_log}}');
		//$this->dropTable('{{pick_pendant_events}}');
		//$this->dropTable('{{events_pendant_manage}}');

		//$this->dropTable('{{global_event_pendant_template}}');
		$this->createTable('{{global_event_pendant_template}}', array(
			'id_global_event_pendant_template' => "pk",
			'desc_global_event' => "varchar(150) NOT NULL",
			'id_pendant_type' => "int(10) DEFAULT NULL",
			'pick_event_type' => "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
			'id_global_message' => "int(10) unsigned DEFAULT NULL",
			'live_panel' => "enum('Y','N') DEFAULT 'Y'",
			'require_acknowledge' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close' => "enum('Y','N') DEFAULT 'Y'",
			'flashing_toggle' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close_duration' => "tinyint(3) unsigned DEFAULT NULL",
			'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->addForeignKey('FK_global_event_pendant_template_pendant_type', '{{global_event_pendant_template}}','id_pendant_type', '{{pendant_type}}', 'id_pendant_type', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_global_event_pendant_template_global_message', '{{global_event_pendant_template}}','id_global_message', '{{global_messages}}', 'id_global_message', 'CASCADE', 'CASCADE');

		//$this->addColumn('{{receiver}}', 'id_global_event_pendant_template', "int(11) NOT NULL");


		echo "Create Events Pendant Manage Table \n\r";
		//$this->dropTable('{{events_pendant_manage}}');
		$this->createTable('{{events_pendant_manage}}', array(
			'id_event_pendant' => 'pk',
			'id_device' =>  "int(10) NOT NULL DEFAULT '0'",
			'id_pendant_type' =>  "int(10) DEFAULT '0'",
			'event_type' => "enum('template','custom') NOT NULL",
			'id_global_event' => "int(11) DEFAULT NULL",
			'live_panel' => "enum('Y','N') DEFAULT 'Y'",
			'require_acknowledge' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close' => "enum('Y','N') DEFAULT 'Y'",
			'flashing_toggle' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close_duration' => "tinyint(3) unsigned DEFAULT NULL",
			'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		echo "Table Events Pendant Manage Created \n\r\n\r";

		echo "Create Pick Pendant Events Table \n\r";
		//$this->dropTable('{{pick_pendant_events}}');
		$this->createTable('{{pick_pendant_events}}', array(
			'id_pick_pendant_event' => 'pk',
			'id_event_pendant' =>  "int(10) NOT NULL DEFAULT '0'",
			'pick_event_type' =>  "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
			'id_contact' => "int(10) unsigned DEFAULT NULL",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		echo "Table Pick Pendant Events Created \n\r\n\r";

		echo "Add Foreign key of Events Pendant Manage Table\n\r";
		$this->addForeignKey('FK_events_pendant_manage_id_pendant', '{{events_pendant_manage}}','id_pendant_type', '{{pendant_type}}', 'id_pendant_type', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_events_pendant_manage_id_pendant_type', '{{events_pendant_manage}}','id_device', '{{pendant_devices}}', 'id_pendant_device', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_events_pendant_manage_id_global_event', '{{events_pendant_manage}}','id_global_event', '{{global_event_pendant_template}}', 'id_global_event_pendant_template', 'CASCADE', 'CASCADE');
		echo "Added successfuly Foreign key of Events Pendant Manage Table\n\r";

		echo "Add Foreign key of Pick  Pendant Events Table\n\r";
		$this->addForeignKey('FK_id_event_pendant', '{{pick_pendant_events}}','id_event_pendant', '{{events_pendant_manage}}', 'id_event_pendant', 'CASCADE', 'CASCADE');



		echo "Create Notification Pendant Log Table \n\r";
		//$this->dropTable('{{notification_pendant_log}}');
		$this->createTable('{{notification_pendant_log}}', array(
			'id_log' => 'pk',
			'serial_number' => "varchar(10) DEFAULT NULL",
			'AntennaInt' => "tinyint unsigned DEFAULT NULL",
			'EventType' => "varchar(50) DEFAULT NULL",
			'PendantRxLevel' => "tinyint unsigned DEFAULT NULL",
			'LowBattery' => "tinyint unsigned DEFAULT NULL",
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
		echo "Table Notification Pendant Log Created \n\r\n\r";

	}

	public function down()
	{

//		$this->dropForeignKey('FK_events_pendant_manage_id_device', '{{events_pendant_manage}}');
//		$this->dropForeignKey('FK_events_pendant_manage_id_pendant_type', '{{events_pendant_manage}}');
//		$this->dropForeignKey('FK_events_pendant_manage_id_global_event', '{{events_pendant_manage}}');
		$this->dropTable('{{global_event_pendant_template}}');
		$this->dropTable('{{notification_pendant_log}}');
		$this->dropTable('{{pick_pendant_events}}');
		$this->dropTable('{{events_pendant_manage}}');
		$this->dropColumn('{{receiver}}','id_global_event_pendant_template');
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