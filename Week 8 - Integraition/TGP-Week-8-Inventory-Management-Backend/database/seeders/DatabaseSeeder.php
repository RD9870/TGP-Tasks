<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories (7 entries)
        $categories = ['Dairy', 'Bakery', 'Beverages', 'Snacks', 'Canned Goods', 'Produce', 'Frozen Foods'];
        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'name' => $cat,
                'created_at' => now(),
            ]);
        }

        // 2. Seed Subcategories (7 entries)
        $subcategories = [
            ['name' => 'Milk', 'category_id' => 1],
            ['name' => 'Bread', 'category_id' => 2],
            ['name' => 'Soft Drinks', 'category_id' => 3],
            ['name' => 'Chips', 'category_id' => 4],
            ['name' => 'Vegetables', 'category_id' => 6],
            ['name' => 'Fruits', 'category_id' => 6],
            ['name' => 'Ice Cream', 'category_id' => 7],
        ];
        DB::table('subcategories')->insert($subcategories);

        // 3. Seed Manufacturers (7 entries)
        $manufacturers = ['Nestle', 'Unilever', 'PepsiCo', 'Coca-Cola', 'General Mills', 'Kelloggs', 'Danone'];
        foreach ($manufacturers as $man) {
            DB::table('manufacturers')->insert(['name' => $man, 'created_at' => now()]);
        }

        // 4. Seed Import Companies (7 entries)
        for ($i = 1; $i <= 7; $i++) {
            DB::table('import_companies')->insert([
                'name' => "Import Corp $i",
                'email' => "contact$i@importcorp.com",
                'phone' => "555-000$i",
                'address' => "$i Main St, Logistics City",
                'created_at' => now(),
            ]);
        }

        // 5. Seed Users (7 entries)
        $roles = ['admin', 'manager', 'cashier'];
        foreach ($roles as $index => $role) {
            DB::table('users')->insert([
                'username' => "$role",
                'password' => Hash::make('password'),
                'salary' => 2000 + ($index * 100),
                'type' => $role,
                'created_at' => now(),
            ]);
        }

        // 6. Seed Products (20 entries)
        $products = [
            ['Full Cream Milk', 1, 7, 1, "https://i5.walmartimages.com/seo/Great-Value-Milk-Whole-Vitamin-D-Half-Gallon-Plastic-Jug-64oz_52ec45c4-586d-42c0-a42c-93218631e277.ec8d19bdf634f97445cbf455eac874a8.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Sourdough Bread', 2, 5, 2, "https://i5.walmartimages.com/seo/San-Luis-Sourdough-Plain-Sourdough-Bread-24-oz-Sourdough-Bread-Bag_58b541e3-cdc4-4e0e-be0c-31334b331739.71eb32fa6a63fcce992af5046baa93a6.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Cola 500ml', 3, 4, 3, "https://i5.walmartimages.com/seo/Fanta-Shokata-4-Pack-500ml-x-4_f42eff25-0918-4de0-bb1c-3fdf302c2f9c.f72f961f5ebe6c141aeaf2bc94914651.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"],
            ['Potato Chips', 4, 3, 4, "https://i5.walmartimages.com/seo/Ruffles-Original-Flavor-Potato-Snack-Chips-Party-Size-13-Ounce-Bag_b1dfbc1c-be15-4d2f-b1dd-d389c690248d.6b7a42ed32a6bcc6e36b8e3ae175e62d.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Canned Peas', 5, 1, 5, "https://i5.walmartimages.com/seo/Del-Monte-Canned-Sweet-Peas-105-oz-Can_fd2aa191-33b9-40c4-bcd0-1efd36540d7f.75f3078d4e08ecb0866b7a0831469522.jpeg"], ['Fresh Apple', 6, 2, 6, "https://i5.walmartimages.com/seo/Fresh-Gala-Apples-3-lb-Bag_bcfd9451-a73b-411f-84e3-1d866f833ae8.3e996f05a24facfa2ac526d6c631401d.jpeg?odnHeight=573&odnWidth=573&odnBg=FFFFFF"],
            ['Vanilla Ice Cream', 7, 7, 7, "https://i5.walmartimages.com/seo/Great-Value-Vanilla-Bean-Flavored-Ice-Cream-48-fl-oz_4ed934d9-d42b-4244-80e2-0b69ab20bfe8.95523c24ecd364d8da5fed21bcccabee.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Greek Yogurt', 1, 7, 1, "https://i5.walmartimages.com/seo/Great-Value-Greek-Plain-Nonfat-Yogurt-32-oz-Tub_e9c7b7c1-c90a-4fe3-839e-3c5b0264de38.7c8cd5cf2fa6557244ddb1df6cae77b0.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Whole Wheat Bread', 2, 5, 2, "https://i5.walmartimages.com/seo/Great-Value-100-Whole-Wheat-Round-Top-Bread-20-oz_087c7ba1-b2ab-491c-aac1-7a22a7769f27.29dc3af7a24b0acccc6ac7ca57ad9264.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"],
            ['Orange Juice', 3, 4, 3,"https://i5.walmartimages.com/seo/Simply-Orange-Pulp-Free-Orange-Juice-46-fl-oz-Bottle_08c9f11e-2995-44a3-b165-8badf4d80777.089aa192c0d039b3f92e8712f0a89865.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Chocolate Bar', 4, 1, 4,"https://i5.walmartimages.com/seo/Hershey-s-Milk-Chocolate-Candy-Bar-1-55-oz_ce9f7cd3-8f46-4324-a460-9f0610b43da8.fae42615bdbf2c129f79f7120c12aaff.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Canned Corn', 5, 2, 5, "https://i5.walmartimages.com/seo/Great-Value-Golden-Sweet-Whole-Kernel-Corn-15-Oz_edbab888-dded-4641-abab-29c87eb28c44.e1a86f4acffc6e0591a4f4a38fcb7a30.png?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"],
            ['Banana Pack', 6, 6, 6, "https://i5.walmartimages.com/seo/Marketside-Fresh-Organic-Bananas-Bunch_f17ef225-0999-4035-9ed1-7a06607333b4.7c3b33492f937bcc19fe3339d5230929.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Frozen Pizza', 7, 5, 7,"https://i5.walmartimages.com/seo/Red-Baron-Pepperoni-Brick-Oven-Frozen-Pizza-17-89-oz_df1b825a-9306-434a-9eab-69d7ce691d2f.e7f2f2d9821fdc7bee9d2c7ef1d52977.jpeg?odnHeight=573&odnWidth=573&odnBg=FFFFFF"], ['Butter', 1, 7, 1,"https://i5.walmartimages.com/seo/Great-Value-Sweet-Cream-Salted-Butter-4-Sticks-16-oz-Box-Refrigerated_68307cac-ab72-4da6-aef6-b9cfac319719.595c792b1838cf0751d7d1a462457b12.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"],
            ['Energy Drink', 3, 3, 2,"https://i5.walmartimages.com/seo/GHOST-ENERGY-Zero-Sugars-Energy-Drink-Strawbango-16-fl-oz-Can_aaff89c1-e6bb-4c1d-9f3c-98e62c5f681f.e61307a114278cf74eb54dcd6f091d5f.jpeg?odnHeight=573&odnWidth=573&odnBg=FFFFFF"], ['Tortilla Chips', 4, 3, 3,"https://i5.walmartimages.com/seo/Santitas-White-Corn-Tortilla-Chips-Snack-Chips-11-Ounce-Bag_c92d2b05-920a-43e5-8c64-79b8e5e0f602.0411eabbcaedcae9f1c278b9f975dce6.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Tomato Soup', 5, 1, 4,"https://i5.walmartimages.com/seo/Campbell-s-Condensed-Tomato-Soup-10-75-oz-Can_8b0b784c-13e0-48a0-9491-b217848b3063.dd79f5e027d185257de7a1f36103ef8f.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"],
            ['Frozen Berries', 7, 2, 5,"https://i5.walmartimages.com/seo/Great-Value-Frozen-Whole-Berry-Medley-16-oz_dced2c90-5ad2-4f5d-be72-eb651c54087e.a9ba2d6fa7a3ae402212a6c39bc104a5.jpeg?odnHeight=2000&odnWidth=2000&odnBg=FFFFFF"], ['Cheddar Cheese', 1, 7, 6,"https://i5.walmartimages.com/seo/Great-Value-Finely-Shredded-Mild-Cheddar-Cheese-8-oz_8502ddc0-bdf0-42c2-be27-189e0e671477.b9d05d14cb098ed72bd8e84843566e1c.jpeg?odnHeight=573&odnWidth=573&odnBg=FFFFFF"]
        ];

        foreach ($products as $key => $p) {
            DB::table('products')->insert([
                'code' => 'PROD-' . (1000 + $key),
                'name' => $p[0],
                'subcategory_id' => $p[1],
                'price' => rand(5, 50) + 0.99,
                'manufacture_id' => $p[2],
                'import_company_id' => $p[3],
                "image"=>$p[4],
                'isStockLow' => fake()->boolean(),
                'minimum' => 10,
                'created_at' => now(),
            ]);
        }

        // 7. Seed Stocks (20 entries linked to products)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('stocks')->insert([
                'product_id' => $i,
                'quantity' => rand(20, 100),
                'cost_price' => rand(1, 4) + 0.50,
                'created_at' => now(),
            ]);
        }

        // 8. Seed Receipts (7 entries)
        for ($i = 1; $i <= 7; $i++) {
            DB::table('receipts')->insert([
                'cashier_id' => rand(3, 7), // Picking from the cashiers
                'total' => 0, // Will be updated by items or logic
                'created_at' => now(),
            ]);
        }

        // 9. Seed Receipt Items (At least 7 entries)
        // Note: I used 'recipt_id' as written in your migration typo
        // for ($i = 1; $i <= 10; $i++) {
        //     DB::table('receipt_items')->insert([
        //         'recipt_id' => rand(1, 7),
        //         'product_id' => rand(1, 20),
        //         'quantity' => rand(1, 5),
        //         'item_total' => rand(10, 100),
        //         'created_at' => now(),
        //     ]);
        // }

         $items = [
            // --- BEST SELLERS ---
            // Product 1 (Milk) - Sold many times in large amounts
            ['recipt_id' => 1, 'product_id' => 1, 'quantity' => 10, 'item_total' => 35.00],
            ['recipt_id' => 2, 'product_id' => 1, 'quantity' => 15, 'item_total' => 52.50],
            ['recipt_id' => 3, 'product_id' => 1, 'quantity' => 20, 'item_total' => 70.00],

            // Product 2 (Bread) - Sold many times
            ['recipt_id' => 1, 'product_id' => 2, 'quantity' => 5, 'item_total' => 12.50],
            ['recipt_id' => 4, 'product_id' => 2, 'quantity' => 8, 'item_total' => 20.00],
            ['recipt_id' => 5, 'product_id' => 2, 'quantity' => 12, 'item_total' => 30.00],

            // Product 3 (Cola) - Sold many times
            ['recipt_id' => 2, 'product_id' => 3, 'quantity' => 25, 'item_total' => 50.00],
            ['recipt_id' => 6, 'product_id' => 3, 'quantity' => 10, 'item_total' => 20.00],

            // --- AVERAGE SELLERS ---
            ['recipt_id' => 3, 'product_id' => 5, 'quantity' => 4, 'item_total' => 16.00],
            ['recipt_id' => 7, 'product_id' => 6, 'quantity' => 3, 'item_total' => 9.00],
            ['recipt_id' => 4, 'product_id' => 8, 'quantity' => 5, 'item_total' => 25.00],

            // --- WORST SELLERS ---
            // Product 19 (Frozen Berries) - Only 1 sold total
            ['recipt_id' => 1, 'product_id' => 19, 'quantity' => 1, 'item_total' => 15.00],

            // Product 20 (Cheddar Cheese) - Only 2 sold total
            ['recipt_id' => 5, 'product_id' => 20, 'quantity' => 2, 'item_total' => 12.00],

            // Product 15 (Butter) - Only 2 sold total
            ['recipt_id' => 7, 'product_id' => 15, 'quantity' => 2, 'item_total' => 10.00],
        ];

        foreach ($items as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('receipt_items')->insert($item);
        }
    }
}
