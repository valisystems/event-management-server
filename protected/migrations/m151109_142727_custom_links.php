<?php

class m151109_142727_custom_links extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{custom_links}}', array(
			'id_custom_links' => 'pk',
			'desc_custom_links' => "varchar(50) DEFAULT NULL",
			'url_custom_links' => "varchar(50) DEFAULT NULL",
			'target_type' => 'enum("blank","self","parent", "top") DEFAULT "blank"',
			'location_links' => 'enum("local","external") DEFAULT "local"'
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->addColumn('{{custom_links}}', 'iframe_width', 'smallint unsigned DEFAULT NULL');
		$this->addColumn('{{custom_links}}', 'iframe_width_mesure', 'enum("px","%") DEFAULT "%"');
		$this->addColumn('{{custom_links}}', 'iframe_height', 'smallint unsigned DEFAULT NULL');
	}

	public function down()
	{
		$this->dropTable('{{custom_links}}');

	}
}