<?php

use Phinx\Migration\AbstractMigration;

class CreateStudentsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('students', ['signed' => false]);

        $table->addColumn('name', 'string', ['limit' => 255]);
        $table->addColumn('email', 'string', ['limit' => 255]);
        $table->addColumn('birth_at', 'datetime', ['null' => false]);
        $table->addColumn('created_at', 'datetime', ['null' => false]);
        $table->addColumn('modified_at', 'datetime', ['null' => false]);
        $table->addIndex(
            ['name'],
            [
                'name' => 'idx_name_students'
            ]
        );
        $table->create();
    }
}
