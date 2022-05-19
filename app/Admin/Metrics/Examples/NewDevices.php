<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use IEXBase\TronAPI\Tron;
use DB;
use IEXBase\TronAPI\Support\Base58;
use GuzzleHttp\Client;

class NewDevices extends Donut
{
    protected $labels = ['TRX', 'USDT'];

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('热钱包余额');
        $this->subTitle('Now');
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill();

        return parent::render();
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill()
    {
        $TRX = $this->getbalance("TRX");
        $USDT = $this->getbalance("USDT");
        $this->withContent($TRX, $USDT);

        // 图表数据
        $this->withChart([$TRX,$USDT]);
    }
    
    
    protected function getbalance($type){
        $uri = 'https://api.trongrid.io';
        $api = new \Tron\Api(new Client(['base_uri' => $uri]));
        $address = DB::table("app_config_hot")->where('id',1)->value("hot_address");
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
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 8px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$desktop}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$mobile}</div>
</div>
HTML
        );
    }
}
