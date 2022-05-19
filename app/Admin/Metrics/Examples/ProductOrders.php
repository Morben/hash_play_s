<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Round;
use Illuminate\Http\Request;
use DB;
class ProductOrders extends Round
{
    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();

        $this->title('Orders');
        $this->chartLabels(['Finished', 'Pending', 'Rejected']);
        $this->dropdown([
            '7' => 'All',
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
                $ying = DB::table("app_order")->where("win_status","ying")->count();
                $shu = DB::table("app_order")->where("win_status","shu")->count();
                $sum = DB::table("app_order")->count();
                // 卡片内容
                $this->withContent($ying, $shu, $sum);

                // 图表数据
                $this->withChart([$ying, $shu, $sum]);

                // 总数
                $this->chartTotal('Total', $sum);
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
            'series' => $data,
        ]);
    }

    /**
     * 卡片内容.
     *
     * @param int $finished
     * @param int $pending
     * @param int $rejected
     *
     * @return $this
     */
    public function withContent($finished, $pending, $rejected)
    {
        return $this->content(
            <<<HTML
<div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
    <div class="chart-info d-flex justify-content-between mb-1 mt-2" >
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-primary"></i>
              <span class="text-bold-600 ml-50">中奖订单</span>
          </div>
          <div class="product-result">
              <span>{$finished}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-warning"></i>
              <span class="text-bold-600 ml-50">未中奖订单</span>
          </div>
          <div class="product-result">
              <span>{$pending}</span>
          </div>
    </div>

     <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-danger"></i>
              <span class="text-bold-600 ml-50">总订单</span>
          </div>
          <div class="product-result">
              <span>{$rejected}</span>
          </div>
    </div>
</div>
HTML
        );
    }
}
