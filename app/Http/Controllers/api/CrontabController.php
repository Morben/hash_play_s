<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use IEXBase\TronAPI\Tron;
use DB;
use IEXBase\TronAPI\Support\Base58;
use GuzzleHttp\Client;

class CrontabController extends Controller
{
    
    //转账 每秒1次
    public function transfer_accounts(){
        //获取未转账列表
        $draw_list = DB::table("app_order")->where(['contractRet'=>"SUCCESS",'open_status'=>"open"])->get();
        
        foreach ($draw_list as $draw){
            // dd($draw);
                if($draw->coin_code == "TRX"){
                $res = $this->send_trx($draw);
                }else if($draw->coin_code == "USDT"){
                    $res = $this->send_usdt($draw);
                }else{
                    $res = "不符合结算";
                } 
            
            
           
        }
        
    }
    
    protected function decrypt($secret)
    {
        //私钥内容 一行的形式
        $privateKey = 'MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJXb2dpa1CCzwXdeJAP2z3h6wooV8ym9LzBooH1WT3G+bCbtcCtw1k9YuTYhd8PhPjvjEceEfNj70eH6bBUnASG++h6wHny5cnR72UnHqBsaNsBjfhV8klZPPK05UIreFCMto6FklCdM4DrZq0UhuIQzl+8jmsJ44O/WuAV7AvQrAgMBAAECgYB0Jjk8t0dQrWIWzZ1mgSYewC8F7atRP3NSttUlL/9VLn0O0tssoEFKsH6kyN3VsT+WFRGTrUlCuDLdTkX1QwzpVDHE931ZvVH6V96aArJK8Ce63CTLmrhl3tozh7HPIjgQ2FjWxQUuNWcRw4DVTLMTo3DIqropON6Sq58rwaEQQQJBANw2/lCicXkHFP0EjewcD4COngy1HsFKjpzMPuKnegEuc7UhKPmDrlqziVnKWIj5kO9jfCRsE9X189DFsZ0ifosCQQCuNgZGdw2m+2yW+3iImChvotO7m/lj1/92Ph8C9OQ6zIqNOFVXagZQ+69TD6UO4OMTZY1VI1zmUnXUrXsrKLThAkA8wUtescJ+so5+09/X8VHxlOdT+DBZAZng9pSu8ae+ZbN0mIZ2eHcE/R160VGl0LzE3vykC9FZKXcv9SrwgFDLAkEAqVttyEzuoblkfHalW60IClbxnT3pOQ3/lBSaE0a9JQg5XUY5eMxirZGvhID+BjPLrMyZk/3XzzS0xfeMeI2PIQJAEGvme26luERNbWMEa5F6QhtGmZ44/pfEAB4ArRqC/hV9M017Xys4ipGSqvcXifv3ltRL4iaC5TiAo8707pT78g==';
    
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
    
        openssl_private_decrypt(base64_decode($secret), $oldData, $res);
    
        return $oldData;
    }


    
    
    public function send_trx($draw){
        
        // dump($draw);
        
        //引入iexbase
        if($draw->shuying_amount <= 0){
            return false;
        }
        $count = DB::table("app_order_wait_send")->where("order_id",$draw->id)->count();
        if($count>0){
            return false;
        }
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        
        try {
            $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }
        $hot_address = DB::table("app_config_hot")->first();
        $from_address = $hot_address->hot_address;
        
        $privatekey = $this->decrypt($hot_address->hot_key);
        $tron->setAddress($from_address);
        $tron->setPrivateKey($privatekey);
       
        $amount = sprintf("%.2f",$draw->shuying_amount);
        $amount = floatval($amount);
        
        try {
            
            $transfer = $tron->send($draw->from_address,$amount);
            
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            die($e->getMessage());
        }
        // dump($transfer);die;
        if(isset($transfer['result']) && $transfer['result']){
            $newdraw['open_status'] = "over";
            $newdraw['update_time'] = date("Y-m-d H:i:s");
            $transfer_record['status'] = $transfer['result'];
        }else{
            $newdraw['update_time'] = date("Y-m-d H:i:s");
            $newdraw['open_status'] = "error";
            $newdraw['remark'] = "结算转账失败:".$transfer['code'];
            $transfer_record['status'] = $transfer['code'];
        }
        $transfer_record['tx_id'] = $transfer['txid'];
        $transfer_record['order_id'] = $draw->id;
        $transfer_record['amount'] = $draw->shuying_amount;
        $transfer_record['from_address'] = $tron->fromHex($transfer['raw_data']['contract'][0]['parameter']['value']['owner_address']);
        $transfer_record['receive_address'] = $tron->fromHex($transfer['raw_data']['contract'][0]['parameter']['value']['to_address']);
        $transfer_record['type'] = $transfer['raw_data']['contract'][0]['type'];
        $transfer_record['coin_code'] = "TRX";
        $transfer_record['status'] = "SUCCESS";
        $transfer_record['create_time'] = date('Y-m-d h:i:s');
        $transfer_record['remark'] = "返奖";
        // $transfer_record['contractRet'] = $transfer['code'];
        
        // 启动事务
        DB::beginTransaction();
         try{
            DB::table('app_order')->where("id",$draw->id)->update($newdraw);
            DB::table('app_order_wait_send')->insert($transfer_record);  
            
            DB::commit();
         } catch(\Illuminate\Database\QueryException $ex){
            
            DB::rollback();
            $newdraw['remark'] = "转账完成，数据更新失败:";
            DB::table('app_order')->where("id",$draw['id'])->update($newdraw);
            //   return $ex;   
         }
       
        
        
    }
    
    public function send_usdt($draw){
        
        if($draw->shuying_amount <= 0){
            return "已结算";
        }
        
        $count = DB::table("app_order_wait_send")->where("order_id",$draw->id)->count();
        if($count>0){
            return "已结算";
        }
        
        $uri = 'https://api.trongrid.io';// shasta testnet
        $api = new \Tron\Api(new Client(['base_uri' => $uri,'headers'=>['TRON-PRO-API-KEY'=>'0a3e45d0-d278-4c3e-a604-01c377789829']]));
        $config = [
            'contract_address' => 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t',// USDT TRC20
            'decimals' => 6,
        ];
        $trc20Wallet = new \Tron\TRC20($api, $config);
        $hot_address = DB::table("app_config_hot")->first();
        $from_address = $hot_address->hot_address;
        $privatekey = $this->decrypt($hot_address->hot_key);
       
        $amount = sprintf("%.2f",$draw->shuying_amount);
        $amount = floatval($amount);
        
        $address = $draw->from_address;
        // dump($privateKey);
        $from = $trc20Wallet->privateKeyToAddress($privatekey);
        // dump($from);
        $to = new \Tron\Address(
            $address,
            '',
            $trc20Wallet->tron->address2HexString($address)
        );
        
        
        // $str = json_decode($str,true);
       
        //发起转账
        $transferData = $trc20Wallet->transfer($from, $to, $amount);
        // dump($transferData);
        // $transferData = json_decode($transferData,true);
        // dump($transferData);
        
        $transfer_record['tx_id'] = $transferData->txID;
        $transfer_record['order_id'] = $draw->id;
        $transfer_record['amount'] = $amount;
        $transfer_record['from_address'] = $from_address;
        $transfer_record['receive_address'] = $address;
        $transfer_record['type'] = "TriggerSmartContract";
        $transfer_record['coin_code'] = "USDT";
        $transfer_record['create_time'] = date("Y-m-d H:i:s");
        $transfer_record['status'] = "SUCCESS";
        $transfer_record['remark'] = "返奖";
        $newdraw['open_status'] = "over";
        $newdraw['update_time'] = date("Y-m-d H:i:s");
        
        // 启动事务
        DB::beginTransaction();
         try{
            DB::table('app_order')->where("id",$draw->id)->update($newdraw);
            DB::table('app_order_wait_send')->insert($transfer_record);
            
            DB::commit();
         } catch(\Illuminate\Database\QueryException $ex){
            
            DB::rollback();
            $newdraw['remark'] = "转账完成，数据更新失败:";
            DB::table('app_order')->where("id",$draw->id)->update($newdraw);
            //   return $ex;   
         }
         
       
        
    }
    
    
    //开奖 每秒一次
    public function Draw_prize(){
        
        //获取需要开奖的数据
        $draw_list = DB::table("app_order")->where(['contractRet'=>"SUCCESS",'open_status'=>'Waiting'])->get();
        

        foreach ($draw_list as $draw){
            // dd($draw);
            $game = DB::table("app_config")->where("to_address",$draw->to_address)->first();
            // dd($game->min_trx);
            //检测是否存在该游戏
            if(!empty($game)){
                //检测投注限额
                if($draw->coin_code == "TRX"){
                    if($draw->put_amount < $game->min_trx){
                    $this->settlement($draw,2,"投资金额小于最低限额，不予退回",1,$game);
                    }else{
                        $res = $this->Get_winning_information($draw,$game);
                    }
                    if($draw->put_amount > $game->max_trx){
                        $this->settlement($draw,1,"投资金额大于最高限额，退回95%",2,$game);
                    }else{
                        $res = $this->Get_winning_information($draw,$game);
                    }
                }else{
                    if($draw->put_amount < $game->min_usd){
                    $this->settlement($draw,2,"投资金额小于最低限额，不予退回",1,$game);
                    }else{
                        $res = $this->Get_winning_information($draw,$game);
                    }
                    if($draw->put_amount > $game->max_usd){
                        $this->settlement($draw,1,"投资金额大于最高限额，退回95%",2,$game);
                    }else{
                        $res = $this->Get_winning_information($draw,$game);
                    }
                }
                
                //计算中奖金额
                
                
                
            }else{
                $res = $this->settlement($draw,2,"游戏地址不存在",1,$game);
            }
            
            // echo $res;
        }
        
        
    }
    
    //结算  1不结算 未中奖  2结算 退回部分金额
    // 转账记录 中奖状态 备注 结算类型 游戏类型
    protected function settlement($draw,$status,$remark,$type,$game){
        $newdraw = [];
        switch ($type) {
            case '1':
                $newdraw['open_status'] = "open";
                $newdraw['win_status'] = "shu";
                $newdraw['remark'] = $remark;
                $newdraw['shuying_amount'] = 0;
                $newdraw['update_time'] = date("Y-m-d H:i:s");
                break;
            case '2':
                //返回部分金额
                $newdraw['open_status'] = "open";
                $newdraw['win_status'] = "shu";
                $newdraw['remark'] = $remark;
                $newdraw['shuying_amount'] = $draw->put_amount * 0.95;
                $newdraw['update_time'] = date("Y-m-d H:i:s");
                break;    
            
            default:
               //code
                break;
        }
        
        $res = DB::table("app_order")->where("id",$draw->id)->update($newdraw);
        if($res){
            return "开奖完成";
        }else{
            return "开奖失败";
        }
    }
    
    //计算开奖金额
    // 转账记录 游戏名 游戏赔率
    protected function Get_winning_information($draw,$game){
        $newdraw = [];
        // dd($draw->hash);
        switch ($game->game_type) {
            case 'baijiale':
                /*
                百家乐庄闲和
                */
                $amount = intval($draw->put_amount);
                $var2 = $draw->hash;
                // dd($draw);
                $var2 = substr($var2, -5);
                $var2 = str_split($var2, 1);
                $Dealerstr = $var2[0] . $var2[1] . $var2[2];
                // $Dealerstr = $this->findNum($Dealerstr);
                $playerstr = $var2[2] . $var2[3] . $var2[4];
                // $playerstr = $this->findNum($playerstr);
                foreach ($var2 as $Key => $val) {
                    // code...
                    if(!is_numeric($val)){
                        $var2[$Key] = 10;
                    }
                }
                $Dealer = $var2[0] + $var2[1] + $var2[2];
                $Dealer = $Dealer % 10;
                $player = $var2[2] + $var2[3] + $var2[4];
                $player = $player % 10;
                
                // 庄
                if($game->game_house == "庄"){
                    if($Dealer > $player){
                    //赢

                        $winmoney = $amount * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "ying";
                        $newdraw['remark'] = "百家乐庄:中奖";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                     }else{
                        $newdraw['shuying_amount'] = 0;
                        $newdraw['remark'] = "百家乐庄:未中奖";
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "shu";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                     }
                }else if($game->game_house == "闲"){
                    if($player > $Dealer){
                    //赢
                        $winmoney = $amount * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "ying";
                        $newdraw['remark'] = "百家乐闲:中奖";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                     }else{
                        $newdraw['shuying_amount'] = 0;
                        $newdraw['remark'] = "百家乐闲:未中奖";
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "shu";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                     }
                }else if($game->game_house == "和"){
                    if($player == $Dealer){
                    //赢
                        $winmoney = $amount * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "ying";
                        $newdraw['remark'] = "百家乐和:中奖";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                     }else{
                        $newdraw['shuying_amount'] = 0;
                        $newdraw['remark'] = "百家乐和:未中奖";
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "shu";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                     }
                }else{
                    
                }
                break;
            case 'danshuang':
                //单双游戏结算  规则:转账金额的个位数和区块哈希值(Block hash)最后的数字（只看数字，不看字母）同为单数或同为双数时，则成功中奖。
                $amount = intval($draw->put_amount);
                
                $var1 = substr($amount, -1);
                $var1 = $var1 % 2;
                
                $var2 = $draw->hash;
                $var2 = $this->findNum($var2);
                $var2 = substr($var2, -1);
                $var2 = $var2 % 2;
                if($var2 == $var1){
                    //中奖 计算中奖金额
                    $winmoney = $amount * $game->odds;
                    $newdraw['shuying_amount'] = $winmoney;
                    $newdraw['open_status'] = "open";
                    $newdraw['win_status'] = "ying";
                    $newdraw['remark'] = "单双游戏:中奖";
                    $newdraw['update_time'] = date("Y-m-d H:s:i");
                    
                }else{
                    //未中奖
                    $newdraw['shuying_amount'] = 0;
                    $newdraw['remark'] = "单双游戏:未中奖";
                    $newdraw['open_status'] = "open";
                    $newdraw['win_status'] = "shu";
                    $newdraw['update_time'] = date("Y-m-d H:s:i");
                }
                break;    
            case 'shuangwei':
                //双尾游戏结算  转账后区块哈希值(Block hash)最后的两位为“数字+字母”或“字母+数字”组合时，则成功中奖。
                $amount = intval($draw->put_amount);
                
                $var2 = $draw->hash;
                $var2 = substr($var2, -2);
                $var2 = str_split($var2, 1);
                if(is_numeric($var2[0]) != is_numeric($var2[1]) ){
                    //中奖
                    $winmoney = $amount * $game->odds;
                    $newdraw['shuying_amount'] = $winmoney;
                    $newdraw['open_status'] = "open";
                    $newdraw['win_status'] = "ying";
                    $newdraw['remark'] = "双尾游戏:中奖";
                    $newdraw['update_time'] = date("Y-m-d H:s:i");
                }else{
                    //未中奖
                    $newdraw['open_status'] = "open";
                    $newdraw['win_status'] = "shu";
                    $newdraw['remark'] = "双尾游戏:未中奖";
                    $newdraw['shuying_amount'] = 0;
                    $newdraw['update_time'] = date("Y-m-d H:s:i");
                }

                break;  
            case 'niuniu':
                //牛牛游戏结算
                /*
                采用【区块哈希值】后五位。平台点数：后五位中的前3位之和；玩家点数：后五位中的后3位之和；字母=10点
                1、牛一~牛二 玩家与平台同点 平台胜；2、牛三~牛牛 玩家与平台同点，按各自结果中的最数字依次比较，字母=10；3、牛三~牛牛 玩家与平台同点，各自结果中数字同点，和局，原额退还给玩家。
                
                */
                $amount = intval($draw->put_amount);
                $var2 = $draw->hash;
                $var2 = substr($var2, -5);
                $var2 = str_split($var2, 1);
                $Dealerstr = $var2[0] . $var2[1] . $var2[2];
                $Dealerstr = $this->findNum($Dealerstr);
                $playerstr = $var2[2] . $var2[3] . $var2[4];
                $playerstr = $this->findNum($playerstr);
                foreach ($var2 as $Key => $val) {
                    // code...
                    if(!is_numeric($val)){
                        $var2[$Key] = 10;
                    }
                }
                $Dealer = $var2[0] + $var2[1] + $var2[2];
                $Dealer = $Dealer % 10;
                $player = $var2[2] + $var2[3] + $var2[4];
                $player = $player % 10;
                
                if($player > $Dealer){
                    //赢
                        
                        $winmoney = $amount + ($amount/10) * $player * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        // $newdraw['huikuan_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "ying";
                        $newdraw['remark'] = "牛牛游戏:玩家点和大于庄家";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                }else if($player == $Dealer){
                    $playerstr = substr($playerstr, 0,1);
                    $Dealerstr = substr($Dealerstr, 0,1);
                    if($player == 1 || $player == 2){
                        //输
                        $newdraw['win_status'] = "shu";
                        $newdraw['open_status'] = "open";
                        $newdraw['remark'] = "牛牛游戏:未中奖";
                        $newdraw['shuying_amount'] = $amount - ($amount/10) * $player * $game->odds;
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                    }else if($player>2 && $playerstr > $Dealerstr ){
                        //赢
                        $winmoney = $amount + ($amount/10) * $player * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "ying";
                        $newdraw['remark'] = "牛牛游戏:牛二以上 玩家数字比庄大 赢";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                    }else if($player>2 && $playerstr = $Dealerstr){
                        //平局 原额返回
                        $winmoney = $amount * $game->odds;
                        $newdraw['shuying_amount'] = $winmoney;
                        $newdraw['open_status'] = "open";
                        $newdraw['win_status'] = "shu";
                        $newdraw['remark'] = "牛牛游戏:牛二以上 玩家等于庄数 和局";
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                        
                    }else{
                        //输了
                        $newdraw['win_status'] = "shu";
                        $newdraw['open_status'] = "open";
                        $newdraw['remark'] = "牛牛游戏:未中奖";
                        $newdraw['shuying_amount'] = $amount - ($amount/10) * $player * $game->odds;
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                    }
                    
                }else{
                    //输
                        $newdraw['win_status'] = "shu";
                        $newdraw['open_status'] = "open";
                        $newdraw['remark'] = "牛牛游戏:未中奖";
                        $newdraw['shuying_amount'] = $amount - ($amount/10) * $player * $game->odds;
                        $newdraw['update_time'] = date("Y-m-d H:s:i");
                }
                break;      
            default:
                // code...
                
                break;
        }
        $res = DB::table("app_order")->where("id",$draw->id)->update($newdraw);
        if($res){
            return "开奖完成";
        }else{
            return "开奖失败";
        }
        
        
    }
    
    public function findNum($str=''){
        
        $str=trim($str);
        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0');
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(in_array($str[$i],$temp)){
                $result.=$str[$i];
            }
        }
        return $result;
        
    }
    
    //
    public function Synchronous_transfer_data(){
        
        $game_address = DB::table("app_config")->where("auto_open","yes")->get();
        // dd($game_address);
        foreach ($game_address as $address){
            
            $this->Gettransferdata_trx($address->to_address);
            
            $this->Gettransferdata_usdt($address->to_address);
        }
    }
    
    //同步区块trx转账记录
    protected function Gettransferdata_trx($address){
        
        
        
        //引入iexbase
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        
        try {
            $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }
        
       
        
        //获取1天内trx转入记录
        $client = new \GuzzleHttp\Client();
        $min_timestamp = time() - 1 * 60;
        $min_timestamp = $min_timestamp*1000;
        // dd($min_timestamp);
        $response = $client->request('GET', 'https://api.trongrid.io/v1/accounts/'.$address.'/transactions?min_timestamp='.$min_timestamp."&limit=200&only_to=true", [
          'headers' => [
            'Accept' => 'application/json',
          ],
        ]);
        $body = json_decode($response->getBody());
        // dump($body);die;
        foreach ($body->data as $transfer){
            $transfer = json_encode($transfer,true);
            $transfer = json_decode($transfer,true);
            //判断是否trx转账
           
            if(isset($transfer['raw_data'])){
                
                if($transfer['raw_data']['contract'][0]['type']  == "TransferContract"){
               
                    $count = DB::table("app_order")->where("hash",$transfer['txID'])->count();
                    $config = DB::table("app_config")->where("to_address",$address)->first();
                    if($count == 0){
                        
                        $transfer_record['hash'] = $transfer['txID'];
                        $transfer_record['game_house'] = $config->game_house;
                        $transfer_record['game_type'] = $config->game_type;
                        $transfer_record['hash_last'] = substr($transfer['txID'],-5);
                        $transfer_record['put_amount'] = $transfer['raw_data']['contract'][0]['parameter']['value']['amount'] / 1000000;
                        $transfer_record['from_address'] = $tron->fromHex($transfer['raw_data']['contract'][0]['parameter']['value']['owner_address']);
                        $transfer_record['to_address'] = $tron->fromHex($transfer['raw_data']['contract'][0]['parameter']['value']['to_address']);
                        // $transfer_record['type'] = $transfer['raw_data']['contract'][0]['type'];
                        $transfer_record['contractRet'] = $transfer['ret'][0]['contractRet'];
                        $transfer_record['create_time'] = date("Y-m-d H:i:s",$transfer['raw_data']['expiration'] / 1000);   
                        $transfer_record['coin_code'] = "TRX";
                        $res = DB::table("app_order")->insert($transfer_record);
                        $this->Superior_Commission($transfer_record);
                    }
                
                }   
            }
            
        }
    }
    
    //同步区块usdt转账记录
    protected function Gettransferdata_usdt($address){
        
        
        
        
        //引入iexbase
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        
        try {
            $tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            exit($e->getMessage());
        }
       
        $client = new \GuzzleHttp\Client();
        $min_timestamp = time() - 10 * 60;
        $min_timestamp = $min_timestamp*1000;
        $response = $client->request('GET', 'https://api.trongrid.io/v1/accounts/'.$address.'/transactions/trc20?min_timestamp='.$min_timestamp."&limit=200&only_to=true", [
          'headers' => [
            'Accept' => 'application/json',
          ],
        ]);
        
        $body = json_decode($response->getBody());
        // dump($body);die;
        foreach ($body->data as $transfer){
            $transfer = json_encode($transfer,true);
            $transfer = json_decode($transfer,true);
            
           
            if($transfer['token_info']['name'] == "Tether USD" && $transfer['type'] == "Transfer" ){
                
                $count = DB::table("app_order")->where("hash",$transfer['transaction_id'])->count();
                $config = DB::table("app_config")->where("to_address",$address)->first();
                if($count == 0 && ($transfer['value'] / 1000000)>=$config->min_usd ){
                        $detail = $tron->getTransaction($transfer['transaction_id']);
                        $transfer_record['hash'] = $transfer['transaction_id'];
                        $transfer_record['game_house'] = $config->game_house;
                        $transfer_record['game_type'] = $config->game_type;
                        $transfer_record['hash_last'] = substr($transfer['transaction_id'],-5);
                        $transfer_record['put_amount'] = $transfer['value'] / 1000000;
                        $transfer_record['from_address'] = $transfer['from'];
                        $transfer_record['to_address'] = $transfer['to'];
                        // $transfer_record['type'] = $detail['raw_data']['contract'][0]['type'];
                        $transfer_record['contractRet'] = $detail['ret'][0]['contractRet'];
                        $transfer_record['create_time'] = date("Y-m-d H:i:s",$transfer['block_timestamp'] / 1000);   
                        $transfer_record['coin_code'] = $transfer['token_info']['symbol'];
                        $res = DB::table("app_order")->insert($transfer_record);
                        $this->Superior_Commission($transfer_record);
                    }
                
            }
        }
    }
    
    //上级分佣
    public function Superior_Commission($transfer){
        
        // $transfer = Db::name("game_record")->find();
        $user = DB::table("app_user")->where("address",$transfer['from_address'])->first();
        if(empty($user)){
            return false;
        }
        if($user->fenyong_enable == "yes"){
           //获取上级
           if($user->father_id > 0){
              
               //一级分利开始
               $this->Superior_Commission_do($transfer,$user->father_id,1);
               $user = DB::table("app_user")->where("id",$user->father_id)->first();
               if($user->father_id > 0){
                   //二级分利开始
                   $this->Superior_Commission_do($transfer,$user->father_id,2);
                   $user = DB::table("app_user")->where("id",$user->father_id)->first();
                   if($user->father_id > 0){
                       //三级
                       $this->Superior_Commission_do($transfer,$user->father_id,3);
                   }
                   
               }
               
              
           }
        }
        
        
    }
    
    protected function Superior_Commission_do($transfer,$pid,$level){
        
        $config = DB::table("app_config_fenhong")->first();
        // $commission1 = $transfer['amount'] * $config[$level-1]['value'] / 100;
        if($level == 1){
            $commission1 = $transfer['put_amount'] * $config->one;
        }else if($level == 2){
            $commission1 = $transfer['put_amount'] * $config->two;
        }else{
            $commission1 = $transfer['put_amount'] * $config->huiyuan_num;
        }
        if($transfer['coin_code'] == "TRX"){
            $commission1 = $commission1 * 0.06;
        }
        
        $game_commission['fenhong_amonut'] = $commission1;
        $game_commission['from_address'] = $transfer['from_address'];
        $game_commission['to_address'] = DB::table("app_user")->where("id",$pid)->value("address");
        $game_commission['coin_code'] = "USDT";
        $game_commission['user_id'] = $pid;
        $game_commission['create_time'] = date("Y-m-d H:i:s");
        $game_commission['remark'] = $level."级分佣,订单交易哈希:".$transfer['hash'];
        DB::table('app_fen_flow')->insert($game_commission);
        DB::table('app_user')->where("id",$pid)->increment('fenhong_balance', $commission1);
        
        
    }
    
}
