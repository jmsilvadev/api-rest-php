<?php

use Phinx\Seed\AbstractSeed;

class StudentsCoursesSeeder extends AbstractSeed
{
    public function run()
    {
        $students    = $this->query('SELECT * FROM students')->fetchAll();
        $courses = $this->query('SELECT * FROM courses')->fetchAll();

        $studentsCourses = [];
        foreach ($students as $student) {
            foreach ($courses as $course) {
                $studentsCourses[] = [
                    'student_id'    => $student['id'],
                    'course_id' => $course['id'],
                ];
            }
        }
        $this->table('students_courses')->insert($studentsCourses)->save();
    }
}
