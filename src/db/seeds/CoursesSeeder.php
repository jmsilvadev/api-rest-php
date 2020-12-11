<?php


use Phinx\Seed\AbstractSeed;

class CoursesSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name' => $faker->name(),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'modified_at' => $faker->date('Y-m-d H:i:s'),
            ];
        }

        $this->table('courses')->insert($data)->save();
    }
}
