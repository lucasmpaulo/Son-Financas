<?php

use Faker\Provider\Base;

use Phinx\Seed\AbstractSeed;
use SONFin\Models\CategoryCost;

use function PHPSTORM_META\map;

class BillPaysSeeder extends AbstractSeed
{
    private $categories;

    public function run()
    {
        require __DIR__ . '/../bootstrap.php';
        $this->categories = CategoryCost::all();
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider($this);
        $billPays = $this->table('bill_pays');
        $data = [];
        foreach (range(1, 20) as $value) {
            $userId = rand(1,4);
            $data[] = [
                'date_launch' => $faker->dateTimeBetween('-1 month')->format('Y/m/d'),
                'name' => $faker->word,
                'value' => $faker->randomFloat(2, 10, 1000), // 2 = decimais, min = 10  e max = 1000
                'user_id' => $userId,
                'category_cost_id' => $faker->categoryId($userId),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        $billPays->insert($data)->save();
    }

    public function categoryId($userId)
    {
        $categories = $this->categories->where('user_id', $userId);
        $categories = $categories->pluck('id');
        return Base::randomElement($categories->toArray());
    }
}
