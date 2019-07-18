<?php

class m150731_194000_maxivox_manufactures extends CDbMigration
{
	public function up()
	{
		echo "Create Maxivox Manufacture Table \n\r";
		$this->createTable('{{maxivox_device}}', array(
			'id_maxivox_device' => "pk",
			'dev_desc' => "varchar(150) NOT NULL",
			'dev_address' => "varchar(20) DEFAULT NULL",
			'id_building' => "int(10) unsigned NOT NULL",
			'id_map' => "int(10) unsigned NOT NULL",
		  	'id_room' => "int(10) unsigned NOT NULL",
			'id_patient' => 'integer(11) unsigned DEFAULT NULL',
		  	'comon_area' => "enum('0','1') NOT NULL DEFAULT '1'",
			'coordonate_on_map' => "varchar(250) DEFAULT NULL",
		  	'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'"
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		/*
		 	CONSTRAINT `FK_devices_id_building` FOREIGN KEY (`id_building`) REFERENCES `mia_buildings` (`id_building`) ON DELETE CASCADE ON UPDATE CASCADE,
		  	CONSTRAINT `FK_devices_id_map` FOREIGN KEY (`id_map`) REFERENCES `mia_maps` (`id_map`) ON DELETE CASCADE ON UPDATE CASCADE,
		  	CONSTRAINT `FK_devices_id_room` FOREIGN KEY (`id_room`) REFERENCES `mia_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE
		 */
		$this->addForeignKey('FK_maxivox_id_building', '{{maxivox_device}}','id_building', '{{buildings}}', 'id_building', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_maxivox_id_map', '{{maxivox_device}}','id_map', '{{maps}}', 'id_map', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_maxivox_id_room', '{{maxivox_device}}','id_room', '{{rooms}}', 'id_room', 'CASCADE', 'CASCADE');



		echo "Table Maxivox Manufacture Created \n\r\n\r";

		$this->createTable('{{maxivox_type}}', array(
			'id_maxivox_type' => 'pk',
			'description' => 'varchar(150) DEFAULT NULL',
			'script' => 'varchar(150) DEFAULT NULL',
			'priority' => 'tinyint(3) unsigned DEFAULT NULL',
			'color_hex' => 'varchar(10) DEFAULT NULL',
		), 'ENGINE=InnoDB CHARSET=utf8');




		$this->createTable('{{global_event_maxivox_template}}', array(
			'id_global_event_maxivox_template' => "pk",
			'desc_global_event' => "varchar(150) NOT NULL",
			'id_maxivox_type' => "int(10) DEFAULT NULL",
			'pick_event_type' => "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
			'id_global_message' => "int(10) unsigned DEFAULT NULL",
			'live_panel' => "enum('Y','N') DEFAULT 'Y'",
			'require_acknowledge' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close' => "enum('Y','N') DEFAULT 'Y'",
			'flashing_toggle' => "enum('Y','N') DEFAULT 'Y'",
			'auto_close_duration' => "tinyint(3) unsigned DEFAULT NULL",
			'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->addForeignKey('FK_global_event_maxivox_template_pendant_type', '{{global_event_maxivox_template}}','id_maxivox_type', '{{maxivox_type}}', 'id_maxivox_type', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_global_event_mxivox_template_global_message', '{{global_event_maxivox_template}}','id_global_message', '{{global_messages}}', 'id_global_message', 'CASCADE', 'CASCADE');

		//$this->addColumn('{{receiver}}', 'id_global_event_pendant_template', "int(11) NOT NULL");


		echo "Create Events MaxiVox Manage Table \n\r";
		//$this->dropTable('{{events_pendant_manage}}');
		$this->createTable('{{events_maxivox_manage}}', array(
			'id_event_maxivox' => 'pk',
			'id_maxivox_device' =>  "int(10) NOT NULL DEFAULT '0'",
			'id_maxivox_type' =>  "int(10) DEFAULT '0'",
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


		echo "Create Pick MaxiVox Events Table \n\r";
		//$this->dropTable('{{pick_pendant_events}}');
		$this->createTable('{{pick_maxivox_events}}', array(
			'id_pick_maxivox_event' => 'pk',
			'id_event_maxivox' =>  "int(10) NOT NULL DEFAULT '0'",
			'pick_event_type' =>  "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
			'id_contact' => "int(10) unsigned DEFAULT NULL",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		echo "Table Pick Pendant Events Created \n\r\n\r";


		echo "Add Foreign key of Events MaxiVox Manage Table\n\r";
		$this->addForeignKey('FK_events_maxivox_manage_id_maxivox', '{{events_maxivox_manage}}','id_maxivox_type', '{{maxivox_type}}', 'id_maxivox_type', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_events_maxivox_manage_id_maxivox_type', '{{events_maxivox_manage}}','id_maxivox_device', '{{maxivox_device}}', 'id_maxivox_device', 'CASCADE', 'CASCADE');
		$this->addForeignKey('FK_events_maxivox_manage_id_global_event', '{{events_maxivox_manage}}','id_global_event', '{{global_event_maxivox_template}}', 'id_global_event_maxivox_template', 'CASCADE', 'CASCADE');
		echo "Added successfuly Foreign key of Events Pendant Manage Table\n\r";

		echo "Add Foreign key of Pick  MaxiVox Events Table\n\r";
		$this->addForeignKey('FK_id_event_maxivox', '{{pick_maxivox_events}}','id_event_maxivox', '{{events_maxivox_manage}}', 'id_event_maxivox', 'CASCADE', 'CASCADE');

		$this->addColumn('{{receiver}}', 'id_global_event_maxivox_template', "int(11) NULL");

	}

	public function down()
	{
		echo "Star dropping foreign key";
		$this->dropForeignKey('FK_maxivox_id_building', '{{maxivox_device}}');
		$this->dropForeignKey('FK_maxivox_id_map', '{{maxivox_device}}');
		$this->dropForeignKey('FK_maxivox_id_room', '{{maxivox_device}}');

		$this->dropForeignKey('FK_global_event_maxivox_template_pendant_type', '{{global_event_maxivox_template}}');
		$this->dropForeignKey('FK_global_event_mxivox_template_global_message', '{{global_event_maxivox_template}}');

		$this->dropForeignKey('FK_events_maxivox_manage_id_maxivox', '{{events_maxivox_manage}}');
		$this->dropForeignKey('FK_events_maxivox_manage_id_maxivox_type', '{{events_maxivox_manage}}');
		$this->dropForeignKey('FK_events_maxivox_manage_id_global_event', '{{events_maxivox_manage}}');

		echo "End Dropping foreign key";

		$this->dropTable('{{maxivox_device}}');
		$this->dropTable('{{global_event_maxivox_template}}');
		//$this->dropTable('{{notification_maxivox_log}}');
		$this->dropTable('{{pick_maxivox_events}}');
		$this->dropTable('{{events_maxivox_manage}}');
		$this->dropTable('{{maxivox_type}}');
		$this->dropColumn('{{receiver}}', 'id_global_event_maxivox_template');

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