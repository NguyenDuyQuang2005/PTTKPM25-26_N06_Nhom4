<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product;
use App\Models\Comment;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        $products = product::all();

        // Các mẫu comment tiếng Việt
        // ty them

        foreach ($products as $product) {
            $count = rand(3, 8); // Mỗi sản phẩm 3-8 comment

            for ($i = 0; $i < $count; $i++) {
                Comment::create([
                    'product_id' => $product->id,
                    'content' => $comments[array_rand($comments)],
                    'rating' => rand(3, 5), // Đánh giá từ 3-5 sao
                    'author_id' => null, // Khách bình luận
                ]);
            }
        }
    }
}