<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call(\Database\Seeds\AftvBcastSeeder::class);
        $this->call(\Database\Seeds\AftvBjSeeder::class);
        $this->call(\Database\Seeds\AftvChatFileSeeder::class);
        $this->call(\Database\Seeds\AftvFileSeeder::class);
        $this->call(\Database\Seeds\AftvIpSeeder::class);
        $this->call(\Database\Seeds\AftvM3u8Seeder::class);
        $this->call(\Database\Seeds\AftvReviewSeeder::class);
        $this->call(\Database\Seeds\ClipSeeder::class);
        $this->call(\Database\Seeds\CommentReplySeeder::class);
        $this->call(\Database\Seeds\CommentThreadSeeder::class);
        $this->call(\Database\Seeds\DeviceSeeder::class);
        $this->call(\Database\Seeds\DislikeSeeder::class);
        $this->call(\Database\Seeds\GoogleClientSeeder::class);
        $this->call(\Database\Seeds\LikeSeeder::class);
        $this->call(\Database\Seeds\LolChampionSeeder::class);
        $this->call(\Database\Seeds\LolGameSeeder::class);
        $this->call(\Database\Seeds\LolMetaSeeder::class);
        $this->call(\Database\Seeds\LolTimelineSeeder::class);
        $this->call(\Database\Seeds\NotificationSeeder::class);
        $this->call(\Database\Seeds\PostSeeder::class);
        $this->call(\Database\Seeds\PubgGameSeeder::class);
        $this->call(\Database\Seeds\PubgMetaSeeder::class);
        $this->call(\Database\Seeds\PubgTimelineSeeder::class);
        $this->call(\Database\Seeds\PwdResetSeeder::class);
        $this->call(\Database\Seeds\UserSeeder::class);
        $this->call(\Database\Seeds\VodSeeder::class);
        $this->call(\Database\Seeds\YtbChannelSeeder::class);
        $this->call(\Database\Seeds\YtbCommentReplySeeder::class);
        $this->call(\Database\Seeds\YtbCommentThreadSeeder::class);
        $this->call(\Database\Seeds\YtbVideoSeeder::class);
    }
}
