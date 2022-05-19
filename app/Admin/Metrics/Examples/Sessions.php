<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class Sessions extends Bar
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $color = Admin::color();

        $dark35 = $color->dark35();

        // 卡片内容宽度
        $this->contentWidth(5, 7);
        // 标题
        $this->title('订单(USDT+TRX*0.063)');
        // 设置下拉选项
        $this->dropdown([
            '7' => 'Last 7 Days',
            '28' => 'Last 28 Days',
            // '30' => 'Last Month',
            // '365' => 'Last Year',
        ]);
        // 设置图表颜色
        $this->chartColors([
            $dark35,
            $dark35,
            $color->primary(),
            $dark35,
            $dark35,
            $dark35
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
            case '28':
                $oldNumber = DB::table("app_order")->where("coin_code","TRX")->whereMonth('create_time',"<",Carbon::today()->subDays(28))->sum("put_amount");
                $oldNumber = $oldNumber * 0.063;
                $oldNumber =  $oldNumber + DB::table("app_order")->where("coin_code","USDT")->whereMonth('create_time',"<",Carbon::today()->subDays(28))->sum("put_amount");
                
                $newNumber = DB::table("app_order")->where("coin_code","TRX")->whereMonth('create_time',">",Carbon::today()->subDays(28))->sum("put_amount");
                $newNumber = $oldNumber * 0.063;
                $newNumber =  $oldNumber + DB::table("app_order")->where("coin_code","USDT")->whereMonth('create_time',">",Carbon::today()->subDays(28))->sum("put_amount");
                
                if($oldNumber != 0){
                    $rate = ($newNumber-$oldNumber)/$oldNumber;
                    if($newNumber > $oldNumber){
                        $rate = "+".$rate."%";
                    }else{
                        $rate = "".$rate."%";
                    }
                    
                }else{
                    $rate = "+0%";
                }
                
                // if()
                
                $this->withContent(array_sum($this->getTransferHistory(28)),$rate);
                $this->withChart([
                    [
                        'name' => 'amount',
                        'data' => $this->getTransferHistory(28),
                    ],
                ]);
            break;
            case '7':
            default:
                $oldNumber = DB::table("app_order")->where("coin_code","TRX")->whereMonth('create_time',"<",Carbon::today()->subDays(7))->sum("put_amount");
                $oldNumber = $oldNumber * 0.063;
                $oldNumber =  $oldNumber + DB::table("app_order")->where("coin_code","USDT")->whereMonth('create_time',"<",Carbon::today()->subDays(7))->sum("put_amount");
                
                $newNumber = DB::table("app_order")->where("coin_code","TRX")->whereMonth('create_time',">",Carbon::today()->subDays(7))->sum("put_amount");
                $newNumber = $oldNumber * 0.063;
                $newNumber =  $oldNumber + DB::table("app_order")->where("coin_code","USDT")->whereMonth('create_time',">",Carbon::today()->subDays(7))->sum("put_amount");
                
                if($oldNumber != 0){
                    $rate = ($newNumber-$oldNumber)/$oldNumber;
                    if($newNumber > $oldNumber){
                        $rate = "+".$rate."%";
                    }else{
                        $rate = "".$rate."%";
                    }
                    
                }else{
                    $rate = "+0%";
                }
                
                // if()
                
                $this->withContent(array_sum($this->getTransferHistory(7)),$rate);
                $this->withChart([
                    [
                        'name' => 'amount',
                        'data' => $this->getTransferHistory(7),
                    ],
                ]);
        }
    }
    
    public function getPercentageChange($oldNumber,$newNumber){
        

        $decreaseValue = ($oldNumber - $newNumber) / $oldNumber;
    
        return $decreaseValue;
    }
    
     public function getTransferHistory($time)
    {
       //统计图表 每日新增
        $time = (int)$time;
        
        $data = DB::table('app_order')->where('create_time', '<', Carbon::now())
            ->where('create_time', '>', $time > 1 ? Carbon::today()->subDays($time) : Carbon::today())
            ->select([$time > 1 ? DB::raw('DATE(create_time) as time') : DB::raw('DATE_FORMAT(create_time,\'%H\') as time'), DB::raw('sum(put_amount) as count')])
            ->groupBy('time')
            ->get();
            
        $data = json_decode($data,true);
        $datelist = [];
        if(count($data)<7){
            for ($index=$time;$index>0;$index--){
               
                if($this->deep_in_array(Carbon::today()->subDays($index)->format('Y-m-d'),$data) == false){
                    array_push($datelist,0);
                }else {
                    $date = $this->deep_in_array(Carbon::today()->subDays($index)->format('Y-m-d'),$data);
                    array_push($datelist,$date['count']);
                }
              
            }
           
        }
        
        return $datelist;
    }
    
     public function deep_in_array($value, $array) {   
        foreach($array as $item) {   
            if(!is_array($item)) {   
                if ($item == $value) {  
                    return $item;
                } else {  
                    continue;
                }  
            }   
                
            if(in_array($value, $item)) {  
                return $item;      
            } else if($this->deep_in_array($value, $item)) {  
                return $item;      
            }  
        }   
        return false;   
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
            'series' => $data,
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $title
     * @param string $value
     * @param string $style
     *
     * @return $this
     */
    public function withContent($title, $value, $style = 'success')
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? 'last 7 days'
        );

        $minHeight = '183px';

        return $this->content(
            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <h1 class="font-lg-2 mt-2 mb-0">{$title}</h1>
        <h5 class="font-medium-2" style="margin-top: 10px;">
            <span class="text-{$style}">{$value} </span>
            <span>vs {$label}</span>
        </h5>
    </div>

    <a href="/admin/app_order" class="btn btn-primary shadow waves-effect waves-light">View Details <i class="feather icon-chevrons-right"></i></a>
</div>
HTML
        );
    }
}
