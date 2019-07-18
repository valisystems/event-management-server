<?php

class m150910_140600_ip_address_add_field extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{devices}}', 'ip_address', "varchar(18) DEFAULT NULL");
		$this->createTable('{{mipositioning_input_device}}', array(
			'id_input_device' => 'pk',
			'io_name' => "varchar(50) DEFAULT NULL",
			'io_id' => "varchar(50) DEFAULT NULL",
			'id_device' => "int(10) unsigned NOT NULL DEFAULT '0'"
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		echo "Table miPositioning Input Device Created \n\r\n\r";

		$this->createTable('{{command}}', array(
			'id_command' => 'pk',
			'com_name' => "varchar(50) DEFAULT NULL",
			'command' => "varchar(50) DEFAULT NULL",
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');


		$this->alterColumn('{{global_event_pendant_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{pick_pendant_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{notification_pendant_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "CAMERA", "TRANSFER", "IOPOS") DEFAULT NULL');

		$this->alterColumn('{{global_event_maxivox_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{pick_maxivox_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{notification_maxivox_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');

		$this->alterColumn('{{global_event_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{pick_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');
		$this->alterColumn('{{notification_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA", "IOPOS") DEFAULT NULL');


		$this->addColumn('{{receiver}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{receiver}}', 'id_command', 'int(10) unsigned DEFAULT "0" ');


		$this->addColumn('{{pick_pendant_events}}', 'id_command', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{pick_maxivox_events}}', 'id_command', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{pick_events}}', 'id_command', 'int(10) unsigned DEFAULT "0" ');

		$this->addColumn('{{notification_log}}', 'url', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{notification_log}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{notification_log}}', 'command', 'varchar(50) DEFAULT NULL');

		$this->addColumn('{{notification_pendant_log}}', 'url', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{notification_pendant_log}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{notification_pendant_log}}', 'command', 'varchar(50) DEFAULT NULL');

		$this->addColumn('{{notification_maxivox_log}}', 'url', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{notification_maxivox_log}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{notification_maxivox_log}}', 'command', 'varchar(50) DEFAULT NULL');

		$this->addColumn('{{pick_events}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{pick_maxivox_events}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{pick_pendant_events}}', 'id_iodevice', 'int(10) unsigned DEFAULT "0"');


	}

	public function down()
	{

		$this->dropColumn('{{devices}}','ip_address');
		$this->dropTable('{{mipositioning_input_device}}');

		$this->alterColumn('{{global_event_pendant_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_pendant_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_pendant_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->alterColumn('{{global_event_maxivox_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_maxivox_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_maxivox_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->alterColumn('{{global_event_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->dropColumn('{{receiver}}','id_command');
		$this->dropColumn('{{receiver}}','id_iodevice');
		$this->dropColumn('{{pick_pendant_events}}', 'id_command');
		$this->dropColumn('{{pick_maxivox_events}}', 'id_command');
		$this->dropColumn('{{pick_events}}', 'id_command');

		$this->dropColumn('{{notification_log}}', 'url');
		$this->dropColumn('{{notification_log}}', 'id_iodevice');
		$this->dropColumn('{{notification_log}}', 'command');

		$this->dropColumn('{{notification_pendant_log}}', 'url');
		$this->dropColumn('{{notification_pendant_log}}', 'id_iodevice');
		$this->dropColumn('{{notification_pendant_log}}', 'command');

		$this->dropColumn('{{notification_maxivox_log}}', 'url');
		$this->dropColumn('{{notification_maxivox_log}}', 'id_iodevice');
		$this->dropColumn('{{notification_maxivox_log}}', 'command');

		$this->dropColumn('{{pick_events}}', 'id_iodevice');
		$this->dropColumn('{{pick_maxivox_events}}', 'id_iodevice');
		$this->dropColumn('{{pick_pendant_events}}', 'id_iodevice');

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