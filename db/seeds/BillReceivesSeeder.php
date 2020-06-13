<?php

use Faker\Provider\Base;

use Phinx\Seed\AbstractSeed;
use function PHPSTORM_META\map;

class BillReceivesSeeder extends AbstractSeed
{
    const NAMES = [
        'Salário',
        'Bico',
        'Restituição de imposto de renda',
        'Venda de produtos usados',
        'Bolsa de valores',
        'CDI',
        'Tesouro direto',
        'Previdência privada'
    ];

    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $billReceives = $this->table('bill_receives');
        $data = [];
        foreach (range(1, 20) as $value) {
            $data[] = [
                'date_launch' => $faker->dateTimeBetween('-1 month')->format('Y/m/d'),
                'name' => $faker->BillReceivesName(),
                'value' => $faker->randomFloat(2, 10, 1000), // 2 = decimais, min = 10  e max = 1000
                'user_id' => rand(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $billReceives->insert($data)->save();
    }

    public function BillReceivesName()
    {
        return Base::randomElement(self::NAMES);
    }
}
