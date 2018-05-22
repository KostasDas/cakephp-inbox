<?php
use Migrations\AbstractMigration;

class AddForeignKeysToTasks extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('tasks');
        $table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ]);
        $table->addForeignKey('owner_id', 'users', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ]);
        $table->addForeignKey('hawk_file_id', 'hawk_files', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);
        $table->update();

    }
}
