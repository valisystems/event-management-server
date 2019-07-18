<?php

class m151221_101321_add_update_server_info extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{settings}}', 'update_ems_server', "varchar(250) DEFAULT NULL");
		$this->addColumn('{{settings}}', 'update_ems_key', "varchar(250) DEFAULT NULL");
	}

	public function down()
	{
		$this->dropColumn('{{settings}}','update_ems_server');
		$this->dropColumn('{{settings}}','update_ems_key');
	}
}