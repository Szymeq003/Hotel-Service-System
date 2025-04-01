<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class PhotosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $client = new Client();
        $apiKey = '31301452-169d57aed8dae991b2c0efca8';

        function getPixabayImage($client, $apiKey, $query, $width = 800, $height = 400) {
            $response = $client->get("https://pixabay.com/api/", [
                'query' => [
                    'key' => $apiKey,
                    'q' => $query,
                    'per_page' => 100,
                    'image_type' => 'photo',
                    'orientation' => 'horizontal',
                    'min_width' => $width,
                    'min_height' => $height
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $images = $data['hits'] ?? [];
            if (!empty($images)) {
                $randomImage = $images[array_rand($images)];
                return $randomImage['webformatURL'];
            } else {
                return 'https://via.placeholder.com/800x400.png?text=No+image';
            }
        }

        for ($i = 1; $i <= 100; $i++) {
            DB::table('photos')->insert([
                'photoable_type' => 'App\TouristObject',
                'photoable_id' => $faker->numberBetween(1, 10),
                'path' => getPixabayImage($client, $apiKey, 'city')
            ]);
            sleep(1);
        }

        for ($i = 1; $i <= 200; $i++) {
            DB::table('photos')->insert([
                'photoable_type' => 'App\Room',
                'photoable_id' => $faker->numberBetween(1, 10),
                'path' => getPixabayImage($client, $apiKey, 'room')
            ]);
            sleep(1);
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('photos')->insert([
                'photoable_type' => 'App\User',
                'photoable_id' => $faker->unique()->numberBetween(1, 10),
                'path' => getPixabayImage($client, $apiKey, 'person')
            ]);
            sleep(1);
        }
    }
}
