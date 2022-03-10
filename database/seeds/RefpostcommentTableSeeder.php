<?php

/**
 * Created by: Tanmnt
 * Email: maingocthanhan96@gmail.com
 * Date Time: 2022-03-10 00:24:18
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefpostcommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $comments = \App\Models\comment::all()->pluck('id')->toArray();
        $posts = \App\Models\post::all()->pluck('id')->toArray();

        $limit = 100;

        for ($i = 0; $i < $limit; $i++){
        	\App\Models\Refpostcomment::create([
                'comment_id' => $faker->randomElement($comments),
                'post_id' => $faker->randomElement($posts),
                
			]);
		}
    }
}
