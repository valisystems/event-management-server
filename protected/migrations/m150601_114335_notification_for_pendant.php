<?php

class m150601_114335_notification_for_pendant extends CDbMigration
{
	public function up()
	{
//		$this->dropTable('{{global_event_pendant_template}}');
//		$this->createTable('{{global_event_pendant_template}}', array(
//			'id_global_event_pendant_template' => "pk",
//			'desc_global_event' => "varchar(150) NOT NULL",
//			'id_pendant_type' => "int(10) DEFAULT NULL",
//			'pick_event_type' => "enum('SMS','EMAIL','VOIP','TRANSFER','CAMERA') DEFAULT NULL",
//			'id_global_message' => "int(10) unsigned DEFAULT NULL",
//			'live_panel' => "enum('Y','N') DEFAULT 'Y'",
//			'require_acknowledge' => "enum('Y','N') DEFAULT 'Y'",
//			'auto_close' => "enum('Y','N') DEFAULT 'Y'",
//			'flashing_toggle' => "enum('Y','N') DEFAULT 'Y'",
//			'auto_close_duration' => "tinyint(3) unsigned DEFAULT NULL",
//			'position_popup' => "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'",
//			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
//
//		$this->addForeignKey('FK_global_event_pendant_template_pendant_type', '{{global_event_pendant_template}}','id_pendant_type', '{{pendant_type}}', 'id_pendant_type', 'CASCADE', 'CASCADE');
//		$this->addForeignKey('FK_global_event_pendant_template_global_message', '{{global_event_pendant_template}}','id_global_message', '{{global_messages}}', 'id_global_message', 'CASCADE', 'CASCADE');
//   	ALTER TABLE mia_receiver ADD id_global_event_pendant_template int(11) DEFAULT NULL;
		$this->addColumn('{{receiver}}', 'id_global_event_pendant_template', "int(11) NULL");
		$this->dropForeignKey('FK_receiver_global_event_template','{{receiver}}');


	}

	public function down()
	{
//		$this->dropTable('{{global_event_pendant_template}}');
//		$this->dropColumn('{{receiver}}','id_global_event_pendant_template');
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