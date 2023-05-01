<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    private $amount = 20 - 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create first user
        \App\Models\User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $this->amount);
        $progressBar->setFormat('verbose');
        $progressBar->start();

        $users = User::factory($this->amount)->make()->each(function ($user) use ($progressBar) {
            if ($user->save()) {
                $progressBar->advance();
            }
        });
    }
}
