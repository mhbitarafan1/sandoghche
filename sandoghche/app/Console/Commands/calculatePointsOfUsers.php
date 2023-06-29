<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use PhpParser\Node\Stmt\Foreach_;

class calculatePointsOfUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculatePointsOfUsers:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Points Of Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->calculatePoints();
        }
        $this->info('calculated points');
    }
}
