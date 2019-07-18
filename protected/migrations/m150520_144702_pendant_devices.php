<?php

class m150520_144702_pendant_devices extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{pendant_devices}}', array(
			'id_pendant_device' => 'pk',
			'description' => 'varchar(150) DEFAULT NULL',
			'serial_number' => 'varchar(20) DEFAULT NULL',
			'id_pendant_type' => 'integer(11) NOT NULL',
			'id_patient' => 'integer(11) unsigned DEFAULT NULL',
		), 'ENGINE=InnoDB CHARSET=utf8');

		//ALTER TABLE `mia_pendant_devices` ADD CONSTRAINT `FK_pd_id_pendant_types` FOREIGN KEY (`id_pendant_type`) REFERENCES `mia_pendant_type` (`id_pendant_type`) ON DELETE RESTRICT ON UPDATE NO ACTION

		//$this->addForeignKey('FK_pd_id_patients', '{{pendant_devices}}','id_patient', '{{patients}}', 'id_patient', 'SET NULL', 'NO ACTION');
		$this->addForeignKey('FK_pd_id_pendant_types', '{{pendant_devices}}','id_pendant_type', '{{pendant_type}}', 'id_pendant_type', 'RESTRICT', 'NO ACTION');
	}

	public function down()
	{
		$this->dropTable('{{pendant_devices}}');
	}

}