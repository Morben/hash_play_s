<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Telegram\Bot\Api;
use Carbon\Carbon;
use IEXBase\TronAPI\Support\Base58;
use GuzzleHttp\Client;
  
class ApiController extends Controller
{
    
   
   
    public function test(){
        
      
       /*
       $users = DB::table('users')
                    ->whereNotIn('id', [1, 2, 3])
                    ->get();


       */

//                     $inline_keyboard = [];
//                     $keyboard = ['Keyboard'=>[]];
//                     // $chatid = DB::table("tg_group")->where("chat_id",$chat_id)->value("id");
//                     $btns = DB::table("tg_btn")->where(['bot_id'=>1,'status'=>1])->get();
//                     foreach ($btns as $btn){
           
//                       $callback_data = DB::table("tg_keyword")->where('id',$btn->keywordid)->value('keyword');
//                     //   dd($btn);
//                       if($btn->type==0){
//                             //内联
//                             $btn_data['text'] = "/command1";
//                             // $btn_data['callback_data'] = $callback_data;
                            
//                         } else{
//                             $btn_data['text'] = $btn->btntext;
//                             $btn_data['url'] = $callback_data;
//                         }   
                        
//                          array_push($inline_keyboard,$btn_data);
//                         $btn_data = [];
//                         if(count($inline_keyboard)>=2){
//                             array_push($keyboard['Keyboard'],$inline_keyboard);
//                             $inline_keyboard = [];
//                         }
                      
//                   }
                  
//                   array_push($keyboard['Keyboard'],$inline_keyboard);
//                      $keyboard['resize_keyboard'] = false;
//                      $keyboard['one_time_keyboard'] = true;
//                      $keyboard['selective'] = true;
//                   $encodedKeyboard = json_encode($keyboard);
// $hourglass ="\xE2\x8C\x9B";
//  $Markup = array(
//     'keyboard' => 
//          array($hourglass."Reschedule")
//   ,'resize_keyboard' => true,'one_time_keyboard' => true
// );
//  $telegram = new Api('5330638149:AAF2F95a1Mvj4AUImkaFcyu9zxzgHe7RjOo');
// // var_dump($keyboard);
//     //   dd($encodedKeyboard);
//       $response = $telegram->sendMessage([
//                   'chat_id' => "1966310086",
//                   'text' => "213123",
//                   'reply_markup '=>$Markup,
//                   ]);   
//         die;
       $input = '{"update_id":30065649,"callback_query":{"id":"8445237513207474137","from":{"id":1966310086,"is_bot":false,"first_name":"ru","last_name":"zzznl","username":"saner22","language_code":"zh-hans"},"message":{"message_id":168,"from":{"id":5151163187,"is_bot":true,"first_name":"\u5feb\u4e50\u54c8\u5e0c\ud83d\udcb0\u7cbe\u7075","username":"happyhash88_bot"},"chat":{"id":1966310086,"first_name":"ru","last_name":"zzznl","username":"saner22","type":"private"},"date":1651756991,"text":"\u8054\u7cfb\u4e0a\u7ebf","reply_markup":{"inline_keyboard":[[{"text":"\ud83d\udd25\u725b\u725b\u6e38\u620f","callback_data":"\u725b\u725b\u6e38\u620f"},{"text":"\ud83d\udd25\u5355\u53cc\u6e38\u620f","callback_data":"\u5355\u53cc\u6e38\u620f"}],[{"text":"\ud83d\udd25\u53cc\u5c3e\u6e38\u620f","callback_data":"\u53cc\u5c3e\u6e38\u620f"},{"text":"\ud83d\udd25\u767e\u5bb6\u4e50\u6e38\u620f","callback_data":"\u767e\u5bb6\u4e50\u6e38\u620f"}],[{"text":"\ud83c\udf81\u798f\u5229\u6d3b\u52a8","callback_data":"\u798f\u5229\u6d3b\u52a8"},{"text":"\u260e\ufe0f\u8054\u7cfb\u4e0a\u7ebf","callback_data":"\u8054\u7cfb\u4e0a\u7ebf"}],[{"text":"\ud83e\udd1d\u6211\u7684\u63a8\u5e7f\u94fe\u63a5","callback_data":"\u6211\u7684\u63a8\u5e7f\u94fe\u63a5"},{"text":"\ud83d\udcb0\u76c8\u4e8f\u6d41\u6c34","callback_data":"\u76c8\u4e8f\u6d41\u6c34"}],[{"text":"\u5f00\u542f\u4e2d\u5956\u901a\u77e5","callback_data":"\u5f00\u542f\u4e2d\u5956\u901a\u77e5"},{"text":"\u673a\u5668\u4eba\u6559\u7a0b","callback_data":"\u673a\u5668\u4eba\u6559\u7a0b"}],[{"text":"\u6dfb\u52a0\u73a9\u5bb6\u4fe1\u606f","callback_data":"\u6dfb\u52a0\u73a9\u5bb6\u4fe1\u606f"},{"text":"\u73a9\u5bb6\u5347\u7ea7\u4ee3\u7406","callback_data":"\u73a9\u5bb6\u5347\u7ea7\u4ee3\u7406"}],[{"text":"\u73a9\u5bb6\u91cd\u65b0\u7ed1\u5b9a","callback_data":"\u73a9\u5bb6\u91cd\u65b0\u7ed1\u5b9a"},{"text":"\u6211\u7684\u4ee3\u7406\u4e1a\u7ee9","callback_data":"\u6211\u7684\u4ee3\u7406\u4e1a\u7ee9"}],[{"text":"\u6211\u7684\u73a9\u5bb6\u4e1a\u7ee9","callback_data":"\u6211\u7684\u73a9\u5bb6\u4e1a\u7ee9"},{"text":"\u4ee3\u7406\u540e\u53f0","callback_data":"\u4ee3\u7406\u540e\u53f0"}]]}},"chat_instance":"2306127931996649623","data":"\u4ee3\u7406\u540e\u53f0"}}';
       $input = json_decode($input,true);
       $bot_token = "5151163187:AAHbVWSdHGcQk6vG7_iaF4sVsjSeNeJpZ_k";
       $bot = DB::table("tg_bot")->where("bot_token",$bot_token)->first();
    //   dd($input);
    //   $res = $this->save_chat($input['message']['message_id'],$input['message']['chat']['id'],$input['message']['chat']['username'],$input['message']['chat']['type'],$input['message']['date'],$input['message']['text'],'',$bot->id); 
    //   $res = send_chat($chat_id,$content,$bot_id,$message_id = "");
        // $res = $this->send_chat($input['callback_query']['message']['chat']['id'],$input['callback_query']['data'],$bot->id,"");
        // dd($input);
        $res = $this->save_chat($input['callback_query']['message']['message_id'],$input['callback_query']['message']['chat']['id'],$input['callback_query']['message']['chat']['username'],$input['callback_query']['message']['chat']['type'],$input['callback_query']['message']['date'],$input['callback_query']['data'],'',$bot->id); 
        dd($res);
        
        die;
        DB::table('tg_bot')->orderBy('id')->where("status",1)->chunk(100, function ($bots) {
            
            foreach ($bots as $bot) {
                
                $telegram = new Api($bot->bot_token);
                // dd($telegram);
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
        die;
      $telegram = new Api('5092910984:AAHPqlVVyDxgZEFZOt2gUVLiZ6DYpmc_bq0');
      
      $response  =  $telegram -> forwardMessage ([
          'chat_id'  =>  '5046712185' ,
          'from_chat_id'  =>  '5046712185' ,
        	'message_id'  =>  '234'
        ]);
        
        $messageId  =  $response -> getMessageId ();
      die;
      $inline_keyboard = [];
      $keyboard = ['inline_keyboard'=>[]];
        
      $btns = DB::table("tg_btn")->where(["chat_id"=>5046712185,'bot_id'=>9,'status'=>1])->get();
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
        // $res['photo'] = "https://tgbot.fxroot129.cc/gif/新建项目.jpg";
        $tg_keyword = DB::table("tg_keyword")->where('id',12)->first();
        $response = $telegram->sendphoto([
              'chat_id' => '5046712185',
              'photo' => 'https://tgbot.fxroot129.cc/gif/新建项目.jpg',
              'caption' => $tg_keyword->content,
              'reply_markup'=>$encodedKeyboard
            ]);
        
       
                    
            //  $response = $telegram->sendMessage([
            //   'chat_id' => '5046712185',
            // //   'photo' => 'https://tgbot.fxroot129.cc/vendors/static/img/telegram.png',
            //   'text' => $tg_keyword->content,
            //   'reply_markup'=>$encodedKeyboard,
            //   'parse_mode'=>'Markdown',
            //   'disable_web_page_preview'=>false,
            // ]);



    }
    //
    public function pushmsg($bot_token,Request $request){
        //https://tgbot.fxroot129.cc/storage/markdown/images/f3ccdd27d2000e3f9255a7e3e2c4880061c5bd6d4a5b1.jpg
        //   return true;
        $input = $request->all();
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

        fwrite($myfile, json_encode($input));
        fclose($myfile);
        if(!isset($input['update_id'])){
            return "code:20001,消息格式错误".json_encode($input);
        }
        
        $bot = DB::table("tg_bot")->where("bot_token",$bot_token)->first();
        if($bot->status == 0){
            return "code:20002 机器人未开启监听";
        }
        
        if(isset($input['message']['chat']['type']) && $input['message']['chat']['type'] == "private"){
            //私聊
            if(isset($input['message']['text'])){
                //文本
                $this->save_chat($input['message']['message_id'],$input['message']['chat']['id'],$input['message']['chat']['username'],$input['message']['chat']['type'],$input['message']['date'],$input['message']['text'],'',$bot->id); 
                $this->send_chat($input['message']['chat']['id'],$input['message']['text'],$bot->id);
                
            }else if(isset($input['message']['photo'])){
                //图片
                 $telegram = new Api($bot_token);
                 $response = $telegram->getFile(['file_id' => $input['message']['photo'][0]['file_id']]);
                 $response = json_decode($response,true);
                 $filepath = 'https://api.telegram.org/file/bot'.$bot_token.'/'.$response['file_path'];
                 $this->save_chat($input['message']['chat']['id'],$input['message']['chat']['username'],$input['message']['chat']['type'],$input['message']['date'],$input['message']['caption']??"",$filepath,$bot->id);    
            }else{
                return "未识别私聊";
            }
            
        }else if(isset($input['message']['chat']['type']) && $input['message']['chat']['type'] == "supergroup"){
            //群组
            
            if(isset($input['message']['text'])){
                //文本
                $this->save_chat($input['message']['chat']['id'],$input['message']['chat']['title'],$input['message']['chat']['type'],$input['message']['date'],$input['message']['text'],'',$bot->id);
                $this->send_chat($input['message']['chat']['id'],$input['message']['text'],$bot->id);
            }else if(isset($input['sticker'])){
                //表情
                 $telegram = new Api($bot_token);
                 $response = $telegram->getFile(['file_id' => $input['message']['sticker']['thumb']['file_id']]);
                 $response = json_decode($response,true);
                 $filepath = 'https://api.telegram.org/file/bot'.$bot_token.'/'.$response['file_path'];
                 $this->save_chat($input['message']['chat']['id'],$input['message']['chat']['title'],$input['message']['chat']['type'],$input['message']['date'],$input['sticker']['emoji']??"",$filepath,$bot->id);    
            }else{
                return "未识别群组";
            }
             
         
        }else if(isset($input['channel_post']['chat']['type']) && $input['channel_post']['chat']['type'] == "channel"){
            //频道
            
            if(isset($input['channel_post']['text'])){
                //文本
                 $this->save_chat($input['channel_post']['chat']['id'],$input['channel_post']['chat']['title'],$input['channel_post']['chat']['type'],$input['channel_post']['date'],$input['channel_post']['text'],$input['channel_post']['chat']['title'],$bot->id); 
                 $this->send_chat($input['channel_post']['chat']['id'],$input['channel_post']['text'],$bot->id);
            }else if(isset($input['channel_post']['photo'])){
                //图片
                 $telegram = new Api($bot_token);
                 $response = $telegram->getFile(['file_id' => $input['channel_post']['photo'][0]['file_id']]);
                 $response = json_decode($response,true);
                 $filepath = 'https://api.telegram.org/file/bot'.$bot_token.'/'.$response['file_path'];
                 $this->save_chat($input['channel_post']['chat']['id'],$input['channel_post']['chat']['title'],$input['channel_post']['chat']['type'],$input['channel_post']['date'],'',$filepath,$bot->id);    
            }else{
                return "未识别频道";
            }
            
            
            
        }else if(isset($input['callback_query'])){
            
            //按钮回调
            
            $this->send_chat($input['callback_query']['message']['chat']['id'],$input['callback_query']['data'],$bot->id);
            
            $this->save_chat($input['callback_query']['message']['message_id'],$input['callback_query']['message']['chat']['id'],$input['callback_query']['message']['chat']['username'],$input['callback_query']['message']['chat']['type'],$input['callback_query']['message']['date'],$input['callback_query']['data'],'',$bot->id); 
            
            
        }else{
            return "未识别";
        }
         
        return true;
       
        
    }
    
    //私聊
    /*保存群或频道
    $message_id 消息id
    $username 用户名、群名
    $type 聊天类型
    $date 时间
    $content 聊天内容
    $images 聊天图片
    $bot_id 机器人id
    */
    protected function save_chat($message_id,$chat_id,$username,$type,$date,$content,$images,$bot_id){
        
       
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        
        try {
            $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }
        
          DB::table("tg_msg_record")->insert([
            'chat_id'=> $chat_id,
            'bot_id'=>$bot_id,
            'type' => $type,
            'username'=>$username,
            'content'=>$content,
            'images'=>$images,
            'created_at'=>date("Y-m-d H:i:s",$date),
            'updated_at'=>date("Y-m-d H:i:s",$date),
            ]);
            
          if($type == "channel" || $type == "supergroup" || $type == "private"){
              $chat = DB::table("tg_group")->where("chat_id",$chat_id)->first();
              
              if($chat){
                  $res = DB::table("tg_group")->where("id",$chat->id)->update(['title'=>$username]);
              }else{
                  $res = DB::table("tg_group")->insert([
                      'chat_id'=>$chat_id,
                      'bot_id'=>$bot_id,
                      'title'=>strstr($username,"[",true),
                      'created_at'=>date("Y-m-d H:i:s"),
                      'updated_at'=>date("Y-m-d H:i:s"),
                      ]);
              }
             
              if($type == "private"){
                  
                  
                  
                  if(strpos($content,'/start') !== false){ 
                      $content = str_replace("/start "," ",$content);
                      $content = trim($content);
                      
                      $puser = DB::table("app_user")->where("my_code",$content)->first();
                      
                      if($puser){
                          $user['father_id'] = $puser->id;
                      }else{
                          $user['father_id'] = 0;
                      }
                      $user = DB::table("app_user")->where("tg_name",$username)->count();
                      if($user>0){
                          $this->send_chat($chat_id,"您的电报已注册成功",$bot_id,$message_id);
                      }else{
                          $user['address'] = "";
                          $user['create_time'] = date("Y-m-d H:i:s");
                          $user['fenhong_balance'] = 0 ;
                          $user['fenyong_enable'] = "no";
                          $user['jiesuan_enable'] = "yes";
                          $user['level'] = "";
                          $user['tg_name'] = $username;
                          $user['my_code'] = $this->GetRandStr(7);
                          $user['update_time'] = date("Y-m-d H:i:s");
                          $res = DB::table("app_user")->insert($user);
                          if($res){
                              $this->send_chat($chat_id,"注册成功，回复TRX地址即可绑定帐号",$bot_id,$message_id);
                          }else{
                              $this->send_chat($chat_id,"注册失败",$bot_id,$message_id);
                          }
                      }
                     
                          
                    }
                //添加玩家信息
                if(strpos($content,'username=') !== false && strpos($content,'address=') !== false){ 
                    
                    $userchekc = DB::table("app_user")->where("tg_name",$username)->first();
                    if(!empty($userchekc) && $userchekc->fenyong_enable != "yes"){
                        $text = "您不是代理，无权访问";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);exit;
                    }
                    
                    $zcontent = explode("\n",$content);
                    
                    $addusername = str_replace("username=","",$zcontent[0]);
                    $addaddress = str_replace("address=","",$zcontent[1]);
                    
                    $validateAddress = $tron->validateAddress($addaddress);
                    
                    if($validateAddress['result']){
                      $count = DB::table("app_user")->where("address",$addaddress)->count();
                      if($count > 0 ){ 
                          $text = "该用户已存在，请勿重复添加！";
                          $this->send_chat($chat_id,$text,$bot_id,$message_id);
                      }else{
                          $user = DB::table("app_user")->where("tg_name",$username)->first();
                          $newuser['address'] = $addaddress;
                          $newuser['create_time'] = date("Y-m-d H:i:s");
                          $newuser['father_id'] = $user->id;
                          $newuser['tg_name'] = $addusername;
                          $newuser['my_code'] = $this->GetRandStr(7);
                          $newuser['update_time'] = date("Y-m-d H:i:s");
                          $res = DB::table("app_user")->insert($newuser);
                          if($res){
                              $this->send_chat($chat_id,"添加成功",$bot_id,$message_id);
                          }else{
                              $this->send_chat($chat_id,"添加失败",$bot_id,$message_id);
                          }
                          
                      }
                      
                      
                     }else{
                         $text = "您输入的trc20地址不标准，请检查后再次提交！";
                          $this->send_chat($chat_id,$text,$bot_id,$message_id);
                     }
                    
                    
                }
                //玩家升级代理
                if(!(strpos($content,'username=') !== false) && !(strpos($content,'Inquire_address=') !== false) && strpos($content,'address=') !== false){ 
                    
                    $userchekc = DB::table("app_user")->where("tg_name",$username)->first();
                    if(!empty($userchekc) && $userchekc->fenyong_enable != "yes"){
                        $text = "您不是代理，无权访问";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);exit;
                    }
                    
                          $agent_address = str_replace("address=","",$content);
                          $count = DB::table("app_user")->where("address",$agent_address)->count();
                          if($count>0){
                              $res = DB::table("app_user")->where("address",$agent_address)->update(['fenyong_enable'=>"yes"]);
                              
                                  $text = "玩家升级代理成功！";
                                  $this->send_chat($chat_id,$text,$bot_id,$message_id);  
                              
                          }else{
                            $text = "该用户不存在！";
                            $this->send_chat($chat_id,$text,$bot_id,$message_id);    
                          }
                          
                    
                }
                
                //玩家业绩
                if(!(strpos($content,'username=') !== false) && strpos($content,'Inquire_address=') !== false){ 
                    
                    $userchekc = DB::table("app_user")->where("tg_name",$username)->first();
                    if(!empty($userchekc) && $userchekc->fenyong_enable != "yes"){
                        $text = "您不是代理，无权访问";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);exit;
                    }
                    
                          $Inquire_address = str_replace("Inquire_address=","",$content);
                          $count = DB::table("app_user")->where(["address"=>$Inquire_address,'father_id'=>$userchekc->id])->count();
                          if($count>0){
                                $user = DB::table("app_user")->where("address",$Inquire_address)->first();
                                $today = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address])->count();
                                $ztoday = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address])->count();
                                $text = "";
                                if($today > 0){
                                    $today_trx_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("put_amount");
                                    $today_trx_win = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("huikuan_amount");
                                    
                                    $today_usd_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("put_amount");
                                    $today_usd_win = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("huikuan_amount");
                                    
                                    $text .= "今日投入".$today_trx_touru."TRX,回款".$today_trx_win."TRX"."\n\r";
                                    $text .= "今日投入".$today_usd_touru."USDT,回款".$today_usd_win."USDT"."\n\r";
                                }else{
                                    $text .= "今日未参与游戏"."\n\r";
                                }
                                if($ztoday > 0){
                                    $Ztoday_usd_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("put_amount");
                                    $Ztoday_usd_win = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("huikuan_amount");
                                    $ztoday_trx_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("put_amount");
                                    $ztoday_trx_win = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("huikuan_amount");
                                    
                                    $text .= "昨日投入".$ztoday_trx_touru."TRX,回款".$ztoday_trx_win."TRX"."\n\r";
                                    $text .= "昨日投入".$Ztoday_usd_touru."USDT,回款".$Ztoday_usd_win."USDT"."\n\r";
                                }else{
                                    $text .= "昨日未参与游戏"."\n\r";
                                }
                                
                                $this->send_chat($chat_id,$text,$bot_id,"盈亏流水");
                              
                          }else{
                            $text = "该用户不存在！";
                            $this->send_chat($chat_id,$text,$bot_id,$message_id);    
                          }
                          
                    
                }
                
                //我的代理业绩
                if($content == "我的代理业绩"){
                    $userchekc = DB::table("app_user")->where("tg_name",$username)->first();
                    if(!empty($userchekc) && $userchekc->fenyong_enable != "yes"){
                        $text = "您不是代理，无权访问";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);exit;
                    }
                    //下级人数
                    $son_num = DB::table("app_user")->where('father_id',$userchekc->id)->count();
                    //今日新增 昨日新增会员
                    $today_son_num = DB::table("app_user")->whereDay('create_time', date("D"))->where(["father_id"=>$userchekc->id])->count();
                    $ytoday_son_num = DB::table("app_user")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["father_id"=>$userchekc->id])->count();
                    
                    //统计
                    
                   //一级
                   $son = DB::table("app_user")->where("father_id",$userchekc->id)->pluck("address");
                   $son = json_decode($son);
                   //二级
                   $son_two = DB::table("app_user")->whereIn("father_id",$son)->pluck("address");
                   $son_two = json_decode($son_two);
                   //三级
                   $son_three = DB::table("app_user")->whereIn("father_id",$son_two)->pluck("address");
                   $son_three = json_decode($son_three);
                   $son = array_merge($son,$son_two);
                   $son = array_merge($son,$son_three);
                   
                    $son_today_trx_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["coin_code"=>"TRX"])->whereIn("from_address",$son)->sum("put_amount");    
                    $son_today_usd_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["coin_code"=>"USDT"])->whereIn("from_address",$son)->sum("put_amount");
                    
                    $son_Ztoday_usd_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["coin_code"=>"USDT"])->whereIn("from_address",$son)->sum("put_amount");
                    
                    $son_ztoday_trx_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["coin_code"=>"TRX"])->whereIn("from_address",$son)->sum("put_amount");
                    
                    $fen_sum = DB::table("app_fen_flow")->whereDay('create_time', date("D"))->where("user_id",$userchekc->id)->sum("fenhong_amonut");
                    
                    
                    //下级人数 今日新增会员 昨日新增会员  今日trx流水  昨日usdt流水  今日trx佣金 昨日usdt佣金
                    $text = "----------------------------\n\r";
                    $text .= "下级人数：".$son_num."\n\r";
                    $text .= "今日新增下级:".$today_son_num."人、昨日新增下级:".$ytoday_son_num."人\n\r";
                    $text .= "今日流水: ".$son_today_trx_touru."TRX、".$son_today_usd_touru."USDT\n\r";
                    $text .= "昨日流水: ".$son_ztoday_trx_touru."TRX、".$son_Ztoday_usd_touru."USDT\n\r";
                    $text .= "今日佣金收入总计:".$fen_sum."USDT \n\r";
                    $text .= "当前佣金余额总计剩余:".$userchekc->fenhong_balance."USDT \n\r";
                    $text .= "----------------------------\n\r";
                    $this->send_chat($chat_id,$text,$bot_id,$message_id);  
                    
                    
                }
                if($content == "联系上线"){
                    $user = DB::table("app_user")->where("tg_name",$username)->first();
                    $puser = DB::table("app_user")->where("id",$user->father_id)->first();
                    
                    if($puser){
                        $text = "您的代理上线为 @".$puser->tg_name;
                        $this->send_chat($chat_id,$text,$bot_id,"联系上线");
                    }else{
                        $text = "您没有代理上线";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);
                    }
                }
                //  dd($content);
                if($content == "代理后台"){
                   $userchekc = DB::table("app_user")->where("tg_name",$username)->first();
                    if(!empty($userchekc) && $userchekc->fenyong_enable != "yes"){
                        $text = "您不是代理，无权访问";
                        $this->send_chat($chat_id,$text,$bot_id,$message_id);exit;
                    }
                    
                    $admin = DB::table("admin_users")->where("username",$userchekc->address)->first();
                    if(empty($admin)){
                        $new_admin['username'] = $userchekc->address;
                        $new_admin['password'] = '$2y$10$YJjw9vwDNS20Dc/zLUdkm.5Dfh8Ig6cAtSoLTBaK6wxis7mRiBt6e';
                        $new_admin['name'] = $userchekc->tg_name;
                        $new_admin['created_at'] = date("Y-m-d H:i:s");
                        $uid = DB::table("admin_users")->insertGetId($new_admin);
                        DB::table("admin_role_users")->insert(['role_id'=>2,"user_id"=>$uid]);
                        $admin = DB::table("admin_users")->where("id",$uid)->first();
                        
                    }
                    $text = "----------------------------\n\r";
                    $text .= "代理后台登录地址:https://botadmin.haxiwang.top/admin \n\r\n\r";
                    $text .= "后台登录账号:\n\r";
                    $text .= $admin->username."\n\r\n\r";
                    $text .= "初始登录密码123123\n\r";
                    $text .= "请登录后台后尽快修改密码，且不要泄露给他人";
                    $this->send_chat($chat_id,$text,$bot_id,$message_id);
                }
                
                if($content == "我的推广链接"){
                    $tg_bot = DB::table("tg_bot")->where("status",1)->first();
                    $user = DB::table("app_user")->where("tg_name",$username)->first();
                    $url = "https://t.me/".$tg_bot->username."?start=".$user->my_code;
                    $this->send_chat($chat_id,"您的推广请链接:".$url,$bot_id,"推广链接");
                }  
                
                if($content == "开启中奖通知"){
                    
                    $user = DB::table("app_user")->where("tg_name",$username)->first();
                    if($user->address == "" || $user->tg_name == ""){
                        
                        $this->send_chat($chat_id,"您不符合开启中奖通知",$bot_id,$message_id);
                    }else{
                        $user = DB::table("app_user")->where("tg_name",$username)->update(['notice_status'=>1]);
                        $this->send_chat($chat_id,"已开启中奖通知",$bot_id,$message_id);
                    }
                    
                }  
                
                if($content == "盈亏流水"){
                    $user = DB::table("app_user")->where("tg_name",$username)->first();
                    $today = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address])->count();
                    $ztoday = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address])->count();
                    $text = "";
                    if($today > 0){
                        $today_trx_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("put_amount");
                        $today_trx_win = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("huikuan_amount");
                        
                        $today_usd_touru = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("put_amount");
                        $today_usd_win = DB::table("app_order")->whereDay('create_time', date("D"))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("huikuan_amount");
                        
                        $text .= "今日投入".$today_trx_touru."TRX,回款".$today_trx_win."TRX"."\n\r";
                        $text .= "今日投入".$today_usd_touru."USDT,回款".$today_usd_win."USDT"."\n\r";
                    }else{
                        $text .= "今日未参与游戏"."\n\r";
                    }
                    if($ztoday > 0){
                        $Ztoday_usd_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("put_amount");
                        $Ztoday_usd_win = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"USDT"])->sum("huikuan_amount");
                        $ztoday_trx_touru = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("put_amount");
                        $ztoday_trx_win = DB::table("app_order")->whereDay('create_time', date("D",strtotime("-1 day")))->where(["from_address"=>$user->address,"coin_code"=>"TRX"])->sum("huikuan_amount");
                        
                        $text .= "昨日投入".$ztoday_trx_touru."TRX,回款".$ztoday_trx_win."TRX"."\n\r";
                        $text .= "昨日投入".$Ztoday_usd_touru."USDT,回款".$Ztoday_usd_win."USDT"."\n\r";
                    }else{
                        $text .= "昨日未参与游戏"."\n\r";
                    }
                    
                    $this->send_chat($chat_id,$text,$bot_id,"盈亏流水");
                }  
                
                
                //绑定地址
                $validateAddress = $tron->validateAddress($content);
                  if($validateAddress['result']){
                      $count = DB::table("app_user")->where("tg_name",$username)->count();
                      if($count > 0 ){
                          $user['address'] = $content;
                          
                          DB::table("app_user")->where("tg_name",$username)->update($user);    
                          $text = "绑定成功";
                        //   $text = DB::table("tg_keyword")->where("keyword",'like','%'.$content.'%')->first();
                          $this->send_chat($chat_id,$text,$bot_id,$message_id);
                      }else{
                          $text = "您的账户不存在";
                          $this->send_chat($chat_id,$text,$bot_id,$message_id);
                      }
                      
                      
                  }
              }
          }    
    }
    
   
    
        public  function GetRandStr($length){
        //字符组合
             $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
             $len = strlen($str)-1;
             $randstr = '';
             for ($i=0;$i<$length;$i++) {
              $num=mt_rand(0,$len);
              $randstr .= $str[$num];
             }
             return $randstr;
        }
    
    /*
    推送消息
    $chat_id 群Id或频道id
    $content 群名称或频道名称
    $bot_id 机器人id
    */
    protected function send_chat($chat_id,$content,$bot_id,$message_id = ""){
        
         
        $tg_keyword = DB::table("tg_keyword")->where("keyword",'like','%'.$content.'%')->where(["bot_id"=>$bot_id,'status'=>1])->first();
       
        if($tg_keyword){
            $bot_token = DB::table("tg_bot")->where("id",$bot_id)->value("bot_token");
            $telegram = new Api($bot_token);
            $encodedKeyboard = '';
            //封装按钮
            
            if($tg_keyword->type == 1){
                    $inline_keyboard = [];
                    $keyboard = ['inline_keyboard'=>[]];
                    $chat = DB::table("tg_group")->where("chat_id",$chat_id)->first();
                    $zuser = DB::table("app_user")->where("tg_name",$chat->title)->first();
                    if($zuser->fenyong_enable == "yes"){
                        
                        $btns = DB::table("tg_btn")->where(['bot_id'=>$bot_id,'status'=>1])->get();
                    }else{
                        
                        $btns = DB::table("tg_btn")->where(['bot_id'=>$bot_id,'status'=>1,'groyp'=>1])->get();
                    }
                    
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
                        if(count($inline_keyboard)>=2){
                            array_push($keyboard['inline_keyboard'],$inline_keyboard);
                            $inline_keyboard = [];
                        }
                      
                  }
                  
                  array_push($keyboard['inline_keyboard'],$inline_keyboard);
                  $encodedKeyboard = json_encode($keyboard);
                  
                }
            
            if($tg_keyword->method == "sendphoto"){
                $photo = "https://botadmin.haxiwang.top/storage/".$tg_keyword->file_id;
                $response = $telegram->sendphoto([
                  'chat_id' => $chat_id,
                  'photo' => $photo,
                  'caption' => $tg_keyword->content,
                  'reply_markup'=>$encodedKeyboard,
                ]);
                
            }else{
                
                 $response = $telegram->sendMessage([
                  'chat_id' => $chat_id,
                  'text' => $tg_keyword->content,
                  'reply_markup'=>$encodedKeyboard,
                  ]);     
            }
            
           
           
        }
        $bot_token = DB::table("tg_bot")->where("id",$bot_id)->value("bot_token");
        $telegram = new Api($bot_token);
         if($message_id != ""){
                // dd("2131");
                 $response = $telegram->sendMessage([
                  'chat_id' => $chat_id,
                  'text' => $content,
                  'ReplyKeyboardMarkup'=>$encodedKeyboard ?? "",
                  'reply_to_message_id'=>$message_id,
                  'allow_sending_without_reply'=>true,
                //   'ReplyKeyboardMarkup'=>['keyboard'=>['1','2']]
                  ]);     
            }
         
    }
    
    public function get_romaddress(){
        
       
        // return true;
        //正式环境中最好不要开启 若要在正式环境中开启请替换掉do while结构 该结构虽然获取地址的效率增高 但最使服务器负载运行
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        
        try {
            $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }
        
        do
        {
            $generateAddress = $tron->GenerateAddress();
            $isValid = $tron->isAddress($generateAddress->getAddress());
            $address_hex = $generateAddress->getAddress();
            $private_key = $generateAddress->getPrivateKey();
            $public_key = $generateAddress->getPublicKey();
            $address_base58 = $generateAddress->getAddress(true);
            echo $address_base58."<br>";
            echo $private_key."<br>";
            $res = $this->checkaddress($address_base58);
        }
        while ($res != 1);
        
        if($res == 1){
            DB::table("app_romaddress")->insert([
                'private_key'=>$private_key,
                'public_key'=>$public_key,
                'address_hex'=>$address_hex,
                'address_base58'=>$address_base58,
                'createtime'=>time(),
                
                ]);
        }
        
    
    
    }
    
    public function checkaddress($address_base58){
       
        $address_base58 = str_split($address_base58, 1);
        if($address_base58[33] == $address_base58[32] && $address_base58[32] == $address_base58[31] && $address_base58[31] == $address_base58[30]){
            return 1;
        }
        
        // if($address_base58[0] == $address_base58[1] && $address_base58[1] == $address_base58[2]){
        //     return 1;
        // }
        
        // if($address_base58[33] == $address_base58[32] && $address_base58[32] == $address_base58[31]){
        //     return 1;
        // }
        

        return 2;
        
    }
    
    //中奖通知
    public function Winning_notice(){
        
        $users = DB::table("app_user")->where("notice_status",1)->get();
        foreach ($users as $user){
            $order = DB::table("app_order")->where(["from_address"=>$user->address,'open_status'=>"over","win_status"=>"ying"])
            ->whereTime('update_time', '=', date("H:i:s"))
            ->first();
            // dd($count);
            if($order){
                $bot_token = DB::table("tg_bot")->where("id",1)->value("bot_token");
                $telegram = new Api($bot_token);
                $chat = DB::table("tg_group")->where("title",$user->tg_name)->first();
                if(!empty($chat)){
                    $response = $telegram->sendMessage([
                      'chat_id' => $chat->chat_id,
                      'text' => "您有新的中奖信息,请及时查看\n\r ,中奖哈希:\n\r ".$order->hash,
                      ]); 
                    //   dd($response);
                }
            }
            
        }
        
    }
    
    public function get_config(){
        return "213";
    }
    
}
