<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\RadialBar;
use Illuminate\Http\Request;
use IEXBase\TronAPI\Tron;
use DB;
use IEXBase\TronAPI\Support\Base58;
use GuzzleHttp\Client;

class Tickets extends RadialBar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('今日投盈');
        $this->height(400);
        $this->chartHeight(300);
        $this->chartLabels('Completed Tickets');
        $this->dropdown([
            '7' => 'Days',
            // '28' => 'Last 28 Days',
            // '30' => 'Last Month',
            // '365' => 'Last Year',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        switch ($request->get('option')) {
            case '365':
            case '30':
            case '28':
            case '7':
            default:
                // 卡片内容
                // $this->withContent(162);
                // 卡片底部
                
                //今日投入
                $data['today_trx'] = DB::table("app_order")->whereDay("create_time",date("d"))->where("coin_code","TRX")->sum("put_amount");
                $data['today_trx'] = sprintf("%.2f",$data['today_trx']);
                $data['today_usdt'] = DB::table("app_order")->whereDay("create_time",date("d"))->where("coin_code","USDT")->sum("put_amount");
                $data['today_usdt'] = sprintf("%.2f",$data['today_usdt']);
                //今日用户盈利
                $data['today_trx_ying'] = DB::table("app_order")->whereDay("create_time",date("d"))->where(["coin_code"=>"TRX",'win_status'=>"ying"])->sum("put_amount");
                $data['today_usdt_ying'] = DB::table("app_order")->whereDay("create_time",date("d"))->where(["coin_code"=>"USDT",'win_status'=>"ying"])->sum("put_amount");
                 $data['today_trx_ying'] = sprintf("%.2f",$data['today_trx_ying']);
                  $data['today_usdt_ying'] = sprintf("%.2f",$data['today_usdt_ying']);
                
                //总投入
                $data['trx'] = DB::table("app_order")->where(["coin_code"=>"TRX"])->sum("put_amount");
                $data['usdt'] = DB::table("app_order")->where(["coin_code"=>"USDT"])->sum("put_amount");
                $data['trx'] = sprintf("%.2f",$data['trx']);
                $data['usdt'] = sprintf("%.2f",$data['usdt']);
                
                //用户总盈利
                $data['trx_ying'] = DB::table("app_order")->where(["coin_code"=>"TRX",'win_status'=>"ying"])->sum("put_amount");
                $data['usdt_ying'] = DB::table("app_order")->where(["coin_code"=>"USDT",'win_status'=>"ying"])->sum("put_amount");
                $data['trx_ying'] = sprintf("%.2f",$data['trx_ying']);
                $data['usdt_ying'] = sprintf("%.2f",$data['usdt_ying']);
                $this->withFooter($data);
                // 图表数据
                // $this->withChart(83);
        }
    }
    
    protected function getbalance($type,$address){
        $uri = 'https://api.trongrid.io';
        $api = new \Tron\Api(new Client(['base_uri' => $uri]));
        
        if($type == "TRX"){
            
            $trxWallet = new \Tron\TRX($api);
            $address = new \Tron\Address(
                $address,
                '',
                $trxWallet->tron->address2HexString($address)
            );
            $addressData = $trxWallet->balance($address);
            return $addressData;    
        }else{
            $config = [
                'contract_address' => 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t',// USDT TRC20
                'decimals' => 6,
            ];
            $trc20Wallet = new \Tron\TRC20($api, $config);
            $address = new \Tron\Address(
                $address,
                '',
                $trc20Wallet->tron->address2HexString($address)
            );
            $addressData = $trc20Wallet->balance($address);
            return $addressData;  
        }
        
        
    }

    /**
     * 设置图表数据.
     *
     * @param int $data
     *
     * @return $this
     */
    public function withChart(int $data)
    {
        return $this->chart([
            'series' => [$data],
        ]);
    }

    /**
     * 卡片内容
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex flex-column flex-wrap text-center">
    <h1 class="font-lg-2 mt-2 mb-0">{$content}</h1>
    <small>Tickets</small>
</div>
HTML
        );
    }

    /**
     * 卡片底部内容.
     *
     * @param string $new
     * @param string $open
     * @param string $response
     *
     * @return $this
     */
    public function withFooter($data)
    {
        return $this->footer(
            <<<HTML
         <br><br>
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>今日投入TRX</p>
        <span class="font-lg-1">{$data['today_trx']}</span>
    </div>
    <div class="text-center">
        <p>今日用户盈利TRX</p>
<span class="font-lg-1">{$data['today_trx_ying']}</span>    </div>
    <div class="text-center">
        <p>总投入 (TRX/USDT)</p>
        <span class="font-lg-1">{$data['trx']}/{$data['usdt']}</span>
    </div>
</div>
 <br><br>
<div class="d-flex justify-content-between p-1" style="padding-top: 0!important;">
    <div class="text-center">
        <p>今日投入USDT</p>
        <span class="font-lg-1">{$data['today_usdt']}</span>
    </div>
    <div class="text-center">
        <p>今日用户盈利USDT</p>
        <span class="font-lg-1">{$data['today_usdt_ying']}</span>
    </div>
    <div class="text-center">
        <p>用户总盈利(TRX/USDT)</p>
        <span class="font-lg-1">{$data['trx_ying']}/{$data['usdt_ying']}</span>
    </div>
</div>
HTML
        );
    }
}
