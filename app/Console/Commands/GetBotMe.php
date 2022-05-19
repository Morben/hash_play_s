<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;
use DB;

class GetBotMe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetBotMe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取同步机器人';

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
         DB::table('tg_bot')->orderBy('id')->where("status",1)->chunk(100, function ($bots) {
            
            foreach ($bots as $bot) {
                
                $telegram = new Api($bot->bot_token);
                $response = $telegram->getMe();
                $response = json_decode($response,true);
                DB::table("tg_bot")->where("id",$bot->id)->update([
                    'username'=>$response['username'],
                    'can_join_groups'=>$response['can_join_groups'],
                    'can_read_all_group_messages'=>$response['can_read_all_group_messages'],
                    'supports_inline_queries'=>$response['supports_inline_queries']
                    ]);
            }
        });
        
    }
}
