<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

       $cat1 =  Category::create([
            "name" => "Informatique",
           
            

       ]);

       $cat2 =  Category::create([
        "name" => "phone",
        "parent_id" => $cat1->id

        ]);



        $images = [
"https://m.media-amazon.com/images/I/61pUul1oDlL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71rXSVqET9L._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71iNwni9TsL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71zeXYQRMfL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/814J8FACIRL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71qA45tWZ5L._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/61pUul1oDlL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71rXSVqET9L._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71iNwni9TsL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71zeXYQRMfL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/814J8FACIRL._AC_UL480_QL65_.jpg",
"https://m.media-amazon.com/images/I/71qA45tWZ5L._AC_UL480_QL65_.jpg"

        ];


        
         for($i=0; $i<10; $i++){

        $faker = Faker::create();
           $product = Product::create([
               "name" => $faker->city,
               "description" => $faker->paragraph($nb =2),
               "price" => $faker->numberBetween($min = 500, $max = 1000),
               "image" => $images[$i]

            ]);
            if($i<5){
            ProductCategory::create([
              "product_id" => $product->id,
              "category_id" => $cat1->id
            ]);
        }
        else{
            ProductCategory::create([
                "product_id" => $product->id,
                "category_id" => $cat2->id
              ]);
        }

          }




    }
}
