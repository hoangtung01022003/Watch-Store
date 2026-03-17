<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use App\Models\Banner;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0123456789',
        ]);

        $user1 = User::firstOrCreate(['email' => 'user1@example.com'], [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '0987654321',
        ]);

        $user2 = User::firstOrCreate(['email' => 'user2@example.com'], [
            'name' => 'Jane Smith',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '0912345678',
        ]);

        // 2. Categories
        $categories = ['Men Watches', 'Women Watches', 'Smartwatches', 'Luxury Watches'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat], ['description' => "Category for $cat"]);
        }

        // 3. Brands
        $brands = [
            ['name' => 'Rolex', 'country' => 'Switzerland'],
            ['name' => 'Seiko', 'country' => 'Switzerland'],
            ['name' => 'Casio', 'country' => 'Japan'],
            ['name' => 'Apple', 'country' => 'USA'],
        ];
        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand['name']], ['country' => $brand['country'], 'description' => "Brand {$brand['name']}"]);
        }

        // 4. Products
        $catMen = Category::where('name', 'Men Watches')->first();
        $catSmart = Category::where('name', 'Smartwatches')->first();
        $brandCasio = Brand::where('name', 'Casio')->first();
        $brandApple = Brand::where('name', 'Apple')->first();

        $product1 = Product::firstOrCreate(['slug' => Str::slug('Casio G-Shock 1000')], [
            'name' => 'Casio G-Shock 1000',
            'category_id' => $catMen->id,
            'brand_id' => $brandCasio->id,
            'price' => 2500000,
            'stock' => 50,
            'description' => 'Durable Casio G-Shock watch.',
            'image' => 'casio-gshock.jpg',
            'status' => true,
        ]);

        $product2 = Product::firstOrCreate(['slug' => Str::slug('Apple Watch Series 9')], [
            'name' => 'Apple Watch Series 9',
            'category_id' => $catSmart->id,
            'brand_id' => $brandApple->id,
            'price' => 9900000,
            'stock' => 30,
            'description' => 'Latest Apple Smartwatch.',
            'image' => 'apple-watch.jpg',
            'status' => true,
        ]);

        // 5. Product Images
        ProductImage::firstOrCreate(['product_id' => $product1->id, 'image_url' => 'casio-gshock-side.jpg'], ['is_main' => false]);
        ProductImage::firstOrCreate(['product_id' => $product2->id, 'image_url' => 'apple-watch-side.jpg'], ['is_main' => false]);

        // 6. Product Specs
        ProductSpec::firstOrCreate(['product_id' => $product1->id], [
            'case_size' => '45mm',
            'water_resistance' => '200m',
            'strap_material' => 'Rubber',
            'movement' => 'Quartz',
            'glass_type' => 'Mineral',
        ]);

        ProductSpec::firstOrCreate(['product_id' => $product2->id], [
            'case_size' => '45mm',
            'water_resistance' => '50m',
            'strap_material' => 'Silicon',
            'movement' => 'Electric',
            'glass_type' => 'Sapphire',
        ]);

        // 7. Addresses
        $address = Address::firstOrCreate(['user_id' => $user1->id, 'is_default' => true], [
            'receiver_name' => 'John Doe',
            'phone' => '0987654321',
            'full_address' => '123 Main St',
            'city' => 'Ho Chi Minh',
            'district' => 'District 1',
            'ward' => 'Ben Nghe',
        ]);

        // 8. Orders
        $order1 = Order::firstOrCreate(['id' => 1001], [
            'user_id' => $user1->id,
            'address_id' => $address->id,
            'total_price' => 2500000,
            'status' => 'completed',
            'payment_method' => 'COD',
            'note' => 'Deliver in morning',
        ]);

        $order2 = Order::firstOrCreate(['id' => 1002], [
            'user_id' => $user2->id,
            'address_id' => $address->id,
            'total_price' => 9900000,
            'status' => 'pending',
            'payment_method' => 'Bank Transfer',
        ]);

        // 9. Order Items
        OrderItem::firstOrCreate(['order_id' => $order1->id, 'product_id' => $product1->id], [
            'quantity' => 1,
            'price' => 2500000,
        ]);

        OrderItem::firstOrCreate(['order_id' => $order2->id, 'product_id' => $product2->id], [
            'quantity' => 1,
            'price' => 9900000,
        ]);

        // 10. Banners
        Banner::firstOrCreate(['title' => 'Summer Sale'], [
            'image_url' => 'summer-sale.jpg',
            'link_url' => '/sale',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        
        Banner::firstOrCreate(['title' => 'New Collection'], [
            'image_url' => 'new-collection.jpg',
            'link_url' => '/new',
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
