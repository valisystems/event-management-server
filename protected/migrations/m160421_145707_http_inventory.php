<?php

class m160421_145707_http_inventory extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{http_inventory}}', array(
			'id_http_inventory' => 'pk',
			'description'=>'varchar(250) DEFAULT NULL',
			'type_of_url' => "enum('3cx', 'pbx','vodia', 'custom') NOT NULL DEFAULT '3cx'",
			'type_method_info'=>'varchar(250) DEFAULT NULL',
			'header_info'=>'text',
			'custom_variable'=>'text',
			'action_url'=>'text',
			'urlencode' => "enum('0', '1') NOT NULL DEFAULT '0'"
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');


		$this->alterColumn('{{global_event_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{pick_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{notification_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');


		$this->alterColumn('{{global_event_pendant_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{pick_pendant_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{notification_pendant_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');

		$this->alterColumn('{{global_event_pendant_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{pick_pendant_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{notification_pendant_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');

		$this->alterColumn('{{global_event_maxivox_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{pick_maxivox_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');
		$this->alterColumn('{{notification_maxivox_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP","TRANSFER","CAMERA","IOPOS","HTTP") DEFAULT NULL');


		$this->addColumn('{{http_inventory}}','username', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{http_inventory}}','password', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{http_inventory}}','enconding_message', "enum('json', 'xml','url', 'ascii') NULL DEFAULT 'json'");
		$this->addColumn('{{http_inventory}}','message_body', 'text');
		$this->addColumn('{{http_inventory}}','region', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{http_inventory}}','additional_header', 'text DEFAULT NULL');
		$this->addColumn('{{http_inventory}}','send_method', 'varchar(250) DEFAULT NULL');

		$this->addColumn('{{receiver}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{pick_events}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{notification_log}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{pick_pendant_events}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{notification_pendant_log}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0"');
		$this->addColumn('{{pick_maxivox_events}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0" ');
		$this->addColumn('{{notification_maxivox_log}}', 'id_http_inventory', 'int(10) unsigned DEFAULT "0"');



	}

	public function down()
	{
		$this->dropTable('{{http_inventory}}');

		$this->alterColumn('{{global_event_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->alterColumn('{{global_event_pendant_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_pendant_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_pendant_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->alterColumn('{{global_event_maxivox_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{pick_maxivox_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');
		$this->alterColumn('{{notification_maxivox_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER", "CAMERA") DEFAULT NULL');

		$this->dropColumn('{{receiver}}','id_http_inventory');

		$this->dropColumn('{{receiver}}','id_http_inventory');
		$this->dropColumn('{{pick_pendant_events}}', 'id_http_inventory');
		$this->dropColumn('{{pick_maxivox_events}}', 'id_http_inventory');
		$this->dropColumn('{{pick_events}}', 'id_http_inventory');
		$this->dropColumn('{{notification_log}}', 'id_http_inventory');
		$this->dropColumn('{{notification_pendant_log}}', 'id_http_inventory');
		$this->dropColumn('{{notification_maxivox_log}}', 'id_http_inventory');
	}
}