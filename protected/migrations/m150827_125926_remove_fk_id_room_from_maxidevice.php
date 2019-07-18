<?php

class m150827_125926_remove_fk_id_room_from_maxidevice extends CDbMigration
{
	public function up()
	{
		$this->dropForeignKey('FK_maxivox_id_room', '{{maxivox_device}}');
	}

	public function down()
	{
		$this->addForeignKey('FK_maxivox_id_room', '{{maxivox_device}}','id_room', '{{rooms}}', 'id_room', 'CASCADE', 'CASCADE');
	}
}