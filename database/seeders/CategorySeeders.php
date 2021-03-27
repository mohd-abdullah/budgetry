<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategorySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryList = [
            ['name' => 'Housing'],
            ['name' => 'Transportation'],
            ['name' => 'Food'],
            ['name' => 'Utilities'],
            ['name' => 'Insurance'],
            ['name' => 'Personal Spending'],
            ['name' => 'Entertainment'],
            ['name' => 'Miscellaneous'],
            ['name' => 'Medical & Healthcare']
        ];

        foreach ($categoryList as $category) {
            Categories::create($category);
        }
    }
}
