<?php

use Phinx\Migration\AbstractMigration;

class CreateCoursesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('courses', ['signed' => false]);

        $table->addColumn('name', 'string', ['limit' => 255]);
        $table->addColumn('created_at', 'datetime', ['null' => false]);
        $table->addColumn('modified_at', 'datetime', ['null' => false]);
        $table->addIndex(
            ['name'],
            [
                'name' => 'idx_name_courses'
            ]
        );
        $table->create();
    }
}
