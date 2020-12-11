<?php

use Phinx\Seed\AbstractSeed;

class MainSeeder extends AbstractSeed
{
    protected $seedClasses = [
        CoursesSeeder::class,
        StudentsSeeder::class,
        StudentsCoursesSeeder::class,
    ];

    public function run()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $this->table('students_courses')->truncate();
        $this->table('students')->truncate();
        $this->table('courses')->truncate();


        foreach ($this->seedClasses as $seedClass) {
            $seeder = new $seedClass;
            $seeder->setAdapter($this->getAdapter());
            $seeder->run();
        }

        $this->execute('SET FOREIGN_KEY_CHECKS=1');

    }
}
