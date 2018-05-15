<?php
use Migrations\AbstractMigration;

class CreateHawkFiles extends AbstractMigration
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
        $table = $this->table('hawk_files');
        $table->addColumn('number', 'string');
        $table->addColumn('type', 'string');
        $table->addColumn('topic', 'string');
        $table->addColumn('sender', 'string');
        $table->addColumn('protocol', 'string', [
            'null' => true,
            'default' => 'null'
        ]);
        $table->addColumn('location', 'string');
        $table->addColumn('comments', 'text', [
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('modified', 'datetime');
        $table->create();
    }
}
