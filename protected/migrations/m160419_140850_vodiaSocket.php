<?php

class m160419_140850_vodiaSocket extends CDbMigration
{
	public function up()
	{
		$this->addColumn('{{asterisk}}', 'user', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{asterisk}}', 'passwd', 'varchar(250) DEFAULT NULL');
	}

	public function down()
	{
		$this->dropColumn('{{asterisk}}', 'user');
		$this->dropColumn('{{asterisk}}', 'passwd');
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