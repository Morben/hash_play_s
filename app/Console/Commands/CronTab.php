<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Telegram\Bot\Api;

class CronTab extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronTab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时推送消息';

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
        $cron = DB::table("tg_crontab")->where("status",1)->get();
        foreach ($cron as $Key){
            if( time() - strtotime($Key->updated_at) >= $Key->count_down){
                
                $group = DB::table("tg_group")->where("id",$Key->group_id)->first();
                $bot = DB::table("tg_bot")->where("id",$group->bot_id)->first();
                $keyword = DB::table("tg_keyword")->where("id",$Key->key_id)->first();
                $encodedKeyboard = '';
                $telegram = new Api($bot->bot_token);
                if($keyword->type == 1){
                    $inline_keyboard = [];
                    $keyboard = ['inline_keyboard'=>[]];
                    $btns = DB::table("tg_btn")->where(["chat_id"=>$Key->group_id,'bot_id'=>$group->bot_id,'status'=>1])->get();
                    foreach ($btns as $btn){
           
                       $callback_data = DB::table("tg_keyword")->where('id',$btn->keywordid)->value('keyword');
                    //   dd($btn);
                       if($btn->type==0){
                            //内联
                            $btn_data['text'] = $btn->btntext;
                            $btn_data['callback_data'] = $callback_data;
                            
                        } else{
                            $btn_data['text'] = $btn->btntext;
                            $btn_data['url'] = $callback_data;
                        }   
                        
                         array_push($inline_keyboard,$btn_data);
                        $btn_data = [];
                        if(count($inline_keyboard)>=4){
                            array_push($keyboard['inline_keyboard'],$inline_keyboard);
                            $inline_keyboard = [];
                        }
                      
                  }
                  
                  array_push($keyboard['inline_keyboard'],$inline_keyboard);
                  $encodedKeyboard = json_encode($keyboard);
                  
                }
                
                if($keyword->method == "sendphoto"){
                
                        $response = $telegram->sendphoto([
                          'chat_id' => $group->chat_id,
                          'photo' => $keyword->file_id,
                          'caption' => $keyword->content,
                          'reply_markup'=>$encodedKeyboard,
                        ]);
                        
                
                }else{
                    
                         $response = $telegram->sendMessage([
                          'chat_id' => $group->chat_id,
                          'text' => $keyword->content,
                          'reply_markup'=>$encodedKeyboard,
                          'parse_mode'=>'Markdown',
                          'disable_web_page_preview'=>false,
                        ]);   
                }
                
               
                // $response = $telegram->sendMessage([
                //   'chat_id' => $group->chat_id,
                //   'text' => $keyword->content
                // ]);

                if($response){
                    $res = DB::table("tg_crontab")->where("id",$Key->id)->update(['updated_at'=>date("Y-m-d H:i:s")]);
                }
                
            }
        }
    }
    
   
}
