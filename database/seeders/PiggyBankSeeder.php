<?php

namespace Database\Seeders;

use App\Models\PiggyBank;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PiggyBankSeeder extends Seeder
{
    private $amount = 20;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $this->amount);
        $progressBar->setFormat('verbose');
        $progressBar->start();

        $users = PiggyBank::factory($this->amount)->make()->each(function ($piggyBank) use ($progressBar) {
            if ($piggyBank->save()) {
                $progressBar->advance();
            }
        });
    }
}
