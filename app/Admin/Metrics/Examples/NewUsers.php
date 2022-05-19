<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NewUsers extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('New Users');
        $this->dropdown([
             '7' => 'Last 7 Days',
            '28' => 'Last 28 Days',
            '30' => 'Last Month',
            '365' => 'Last Year',
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
        $generator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };

        switch ($request->get('option')) {
            case '365':
                // 卡片内容
                $this->withContent(array_sum($this->getUserHistory(365)));
                // 图表数据
                $this->withChart($this->getUserHistory(365));
                break;
            case '30':
                // 卡片内容
                $this->withContent(array_sum($this->getUserHistory(30)));
                // 图表数据
                $this->withChart($this->getUserHistory(30));
                break;
            case '28':
                // 卡片内容
                $this->withContent(array_sum($this->getUserHistory(28)));
                // 图表数据
                $this->withChart($this->getUserHistory(28));
                break;
            case '7':
            default:
                // 卡片内容
                
                $this->withContent(array_sum($this->getUserHistory(7)));
                // 图表数据
                
                $this->withChart($this->getUserHistory(7));
        }
    }
    
    
     public function getUserHistory($time)
    {
        //统计图表 每日新增
        $time = (int)$time;
        
        $data = DB::table('app_user')->where('create_time', '<', Carbon::now())
            ->where('create_time', '>', $time > 1 ? Carbon::today()->subDays($time) : Carbon::today())
            ->select([$time > 1 ? DB::raw('DATE(create_time) as time') : DB::raw('DATE_FORMAT(create_time,\'%H\') as time'), DB::raw('COUNT("*") as count')])
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
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}
