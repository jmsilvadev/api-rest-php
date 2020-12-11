<?php


use Phinx\Seed\AbstractSeed;

class StudentsSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name' => $faker->name(),
                'email' => $faker->email(),
                'birth_at' => $faker->date('Y-m-d H:i:s'),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'modified_at' => $faker->date('Y-m-d H:i:s'),
            ];
        }

        $this->table('students')->insert($data)->save();
    }
}
