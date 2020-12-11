<?php

use Phinx\Migration\AbstractMigration;

class CreateStudentsCoursesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('students_courses', ['id' => false, 'primary_key' => ['course_id', 'student_id'], 'signed' => false]);

        $table->addColumn('course_id', 'integer', ['signed' => false, 'null' => false]);
        $table->addColumn('student_id', 'integer', ['signed' => false, 'null' => false]);

        $table->addForeignKey(
            'course_id',
            'courses',
            'id',
            [
                'constraint' => 'fk_courses_students_courses',
                'delete' => 'NO_ACTION',
                'update'=> 'NO_ACTION'
            ]
        );

        $table->addForeignKey(
            'student_id',
            'students',
            'id',
            [
                'constraint' => 'fk_students_students_courses',
                'delete' => 'NO_ACTION',
                'update'=> 'NO_ACTION'
            ]
        );
        $table->addIndex(
            [
                'course_id',
                'student_id'
            ],
            [
                'unique' => true,
                'name' => 'idx_unq_students_courses'
            ]
        );

        $table->create();
    }
}
