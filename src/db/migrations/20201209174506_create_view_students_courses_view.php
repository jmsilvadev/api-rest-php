<?php

use Phinx\Migration\AbstractMigration;

class CreateViewStudentsCoursesView extends AbstractMigration
{
    public function change()
    {
        $this->execute(
            "CREATE OR REPLACE VIEW `view_students_courses` AS
                select
                    `a`.`student_id`,
                    `b`.`name` AS `student_name`,
                    `a`.`course_id`,
                    `c`.`name` AS `course_name`
                from `students_courses` `a`
                join `students` `b`
                on `a`.`student_id` = `b`.`id`
                join `courses` `c`
                on `a`.`course_id` = `c`.`id`
            "
        );
    }
}
