<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DemoDataSeeder::class,
        ]);

        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => true,
            'remember_token' => Str::random(10),
        ]);

        // Categories & Brands
        $categories = Category::factory()->count(4)->create();
        $brands = Brand::factory()->count(4)->create();

        // Products (20 total, random categories/brands)
        for ($i = 0; $i < 20; $i++) {
            $product = Product::factory()->create([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
            ]);

            // Create Specs for each product
            ProductSpec::factory()->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
