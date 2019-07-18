<?php

class m150127_192517_adjuste_transfer_call extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('{{global_event_template}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER") DEFAULT NULL');
		$this->alterColumn('{{pick_events}}', 'pick_event_type', 'enum("SMS","EMAIL","VOIP", "TRANSFER") DEFAULT NULL');
		$this->alterColumn('{{notification_log}}', 'type_notification', 'enum("SMS","EMAIL","VOIP", "TRANSFER") DEFAULT NULL');
		$this->alterColumn('{{events_manage}}', "position_popup", "enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top'");

		//ALTER TABLE mia_events_manage ADD position_popup enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top';
	}

	public function down()
	{
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