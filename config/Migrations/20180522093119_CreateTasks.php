<?php
use Migrations\AbstractMigration;

class CreateTasks extends AbstractMigration
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
        $table->addColumn('hawk_file_id', 'integer');
        $table->addColumn('owner_id', 'integer');
        $table->addColumn('user_id', 'integer');
        $table->addColumn('description', 'text');
        $table->addColumn('read', 'boolean', [
            'default' => 0
        ]);
        $table->addColumn('done', 'boolean',[
            'default' => 0
        ]);
        $table->addColumn('due', 'date', [
            'null' => true,
            'default' => null
        ]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
