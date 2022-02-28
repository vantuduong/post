<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class ActivePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Post::where('status', false)->whereBetween('schedule_publish', [now()->startOfMinute()->toDateTimeString(), now()->endOfMinute()->toDateTimeString()])
            ->update([
                'status' => true
            ]);
    }
}
