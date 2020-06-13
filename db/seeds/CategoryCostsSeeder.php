<?php

use Faker\Provider\Base;

use Phinx\Seed\AbstractSeed;
use function PHPSTORM_META\map;

class CategoryCostsSeeder extends AbstractSeed
{
    const NAMES = [
        'Telefone',
        'Supermercado',
        'Água',
        'Escola',
        'Cartão',
        'Luz',
        'IPVA',
        'Imposto de renda',
        'Gasolina',
        'Vestuário',
        'Entretenimento',
        'Reparos'
    ];

    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $categoryCosts = $this->table('category_costs');
        $data = [];
        foreach (range(1, 20) as $value) {
            $data[] = [
                'name' => $faker->categoryName(),
                'user_id' => rand(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $categoryCosts->insert($data)->save();
    }

    public function categoryName()
    {
        return Base::randomElement(self::NAMES);
    }
}
