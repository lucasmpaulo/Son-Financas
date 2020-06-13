<?php

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{   
    public function run()
    {
        // Instância do application
        $app = require __DIR__ . '/../bootstrap.php';
        $auth = $app->service('auth');

        $faker = \Faker\Factory::create('pt_BR');
        $users = $this->table('users');
    /*  $users->insert([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@user.com',
            'password' => $auth->hashPassword('123456'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ])->save();
        ***** Esta função é parar gerar um usuário admin direto na seed, 
            mas é usado apenas em desenvolvimento *****
    */
        $data = [];
        foreach (range(1, 5) as $value) {
            $data[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'password' => $auth->hashPassword('123456'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $users->insert($data)->save();
    }
}
