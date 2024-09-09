<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function category()
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Fruit',
                'is_show' => true,
            ],
            [
                'id' => 2,
                'name' => 'Vegetables',
                'is_show' => true,
            ],
            [
                'id' => 3,
                'name' => 'Packing',
                'is_show' => true,
            ],
        ];
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $categories], 200);
    }

    public function product()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Strawberry',
                'price' => 5000,
                'weight' => 'kg',
                'category_id' => 1,
                'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2Fgarden_strawberry&psig=AOvVaw3lZnIEpaOvo9p1yQZW6L1m&ust=1724223507724000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCICX9Z__gogDFQAAAAAdAAAAABAE'
            ],
            [
                'id' => 2,
                'name' => 'Diamond Mango',
                'price' => 2000,
                'weight' => '1/pc',
                'category_id' => 2,
                'image' => 'https://5.imimg.com/data5/ANDROID/Default/2022/4/JX/UV/MZ/45117192/product-jpeg-500x500.jpg'

            ],
            [
                'id' => 3,
                'name' => 'Kiwi',
                'price' => 1000,
                'weight' => 'kg',
                'category_id' => 3,
                'image' => 'https://freshsensations.com.au/cdn/shop/products/KiwiFruit.png?v=1643769428'
            ],
            [
                'id' => 4,
                'name' => 'Watermelon',
                'price' => 1500,
                'weight' => '1/pc',
                'category_id' => 1,
                'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fsnaped.fns.usda.gov%2Fresources%2Fnutrition-education-materials%2Fseasonal-produce-guide%2Fwatermelon&psig=AOvVaw3EnYoUYSFZzNo-qy5Umx50&ust=1724223536208000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCOD0zqz_gogDFQAAAAAdAAAAABAE'
            ],
            [
                'id' => 5,
                'name' => 'Onion',
                'price' => 3000,
                'weight' => 'kg',
                'category_id' => 2,
                'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.britannica.com%2Fplant%2Fonion-plant&psig=AOvVaw2SObp5kI9FYcLyNWFUideH&ust=1724223557329000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCNCB5rb_gogDFQAAAAAdAAAAABAE'
            ],
            [
                'id' => 6,
                'name' => 'Salad',
                'price' => 500,
                'weight' => '1/pc',
                'category_id' => 3,
                'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.refreshmyhealth.com%2Fhow-to-make-a-simple-salad-recipe-vegan-gluten-free%2F&psig=AOvVaw38-E5L8PLSo655vcufNr9X&ust=1724223576661000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCIjr-sL_gogDFQAAAAAdAAAAABAE'
            ],
            [
                'id' => 7,
                'name' => 'Apple',
                'price' => 3000,
                'weight' => '1/pc',
                'category_id' => 3,
                'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wiktionary.org%2Fwiki%2Fapple&psig=AOvVaw2zrlSZGthQjnFAKEzDrumO&ust=1724223408634000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCNiY8O_-gogDFQAAAAAdAAAAABAE'
            ],
        ];
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $products], 200);
    }
}
