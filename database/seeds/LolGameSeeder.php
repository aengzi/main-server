<?php

namespace Database\Seeds;

use App\Models\LolChampion;
use App\Models\LolGame;
use App\Models\LolMeta;
use App\Models\Vod;
use Illuminate\Database\Seeder;

class LolGameSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; ++$i) {
            $vod = Vod::factory()->create();
            $game = LolGame::factory()->create([
                'vod_id' => $vod->getKey(),
            ]);
            $champion = LolChampion::orderByRaw('rand()')->first();
            $gameCreation = LolMeta::factory()->create([
                'property' => 'game_creation',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->dateTimeThisYear(),
            ]);
            $gameDuration = LolMeta::factory()->create([
                'property' => 'game_duration',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->randomNumber(4),
            ]);
            $statusKills = LolMeta::factory()->create([
                'property' => 'status_kills',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->randomDigit(),
            ]);
            $statusAssists = LolMeta::factory()->create([
                'property' => 'status_assists',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->randomDigit(),
            ]);
            $statusDeaths = LolMeta::factory()->create([
                'property' => 'status_deaths',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->randomDigit(),
            ]);
            $myTeamWin = LolMeta::factory()->create([
                'property' => 'my_team_win',
                'game_id' => $game->getKey(),
                'value' => \Faker\Factory::create()->randomElement([0, 1]),
            ]);
            $statusChampionId = LolMeta::factory()->create([
                'property' => 'status_champion_id',
                'game_id' => $game->getKey(),
                'value' => $champion->getKey(),
            ]);
            if ($statusKills->value - 1 > 0) {
                $types = ['penta', 'quadra', 'triple', 'double'];
                $statusHasMultiKillType = LolMeta::factory()->create([
                    'property' => 'status_has_multi_kill_type',
                    'game_id' => $game->getKey(),
                    'value' => \Faker\Factory::create()->randomElement(
                        array_splice(
                            $types,
                            ($statusKills->value - 1) * -1,
                        )
                    ),
                ]);
            }
        }
    }
}
