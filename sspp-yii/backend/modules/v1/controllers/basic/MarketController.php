<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/11/15
 * Time: 23:45
 */

namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;

class MarketController extends BackendBaseController
{
    public function actionIndex()
    {
        $itemBaseUrl = 'https://shopee.com.my/';

        $keyword = urlencode(\Yii::$app->request->get('keyword'));
        $header = array('User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
        $url = "https://shopee.com.my/api/v2/search_items/?by=sales&keyword={$keyword}&limit=100&newest=0&order=desc&page_type=search&version=2";
        $res = $this->curlGet($url, $header);
        $arr = json_decode($res, true);

//        echo '<pre>';
//        print_r($arr);
//        echo '</pre>';die();

        //商品总数，计算查询商品总销量，计算出平均价格，广告个数
        $data = [
            'total_count' => $arr['total_count'],
            'total_ads_count' => $arr['total_ads_count'],
        ];

        $totalSold = 0;
        $totalPrice = 0;
        $goodsList = [];
        foreach ($arr['items'] as $k => $v){
            $totalSold += (int)$v['sold'];
            $totalPrice += (int)$v['price'];
            //url，标题，价格，上架时间，天数，点赞数（平均），观看数（平均），历史销量（平均），最近销量，图片
            $days = (int)(time() - (int)$v['ctime'])/86400;
            $imgUrl = 'https://cf.shopee.com.my/file/';
            $imgList = [
                $imgUrl.$v['images'][0]
            ];
            if (count($v['images']) > 1){
                $imgList[] = $imgUrl.$v['images'][1];
            }
            $temp = [
                'url' => $itemBaseUrl.preg_replace("/[\\s|\\[|\\]]+/", '-', str_replace('#','', str_replace('%', '', $v['name']))).'-i.'.$v['shopid'].'.'.$v['itemid'],
                'name' => $v['name'],
                'price' => ((int)$v['price'])/100000,
                'ctime' => date('Y-m-d', $v['ctime']),
                'days' => sprintf("%.2f",$days),
                'liked_count' => $v['liked_count'].'(avg: '.sprintf("%.2f",(int)$v['liked_count']/$days).')',
                'view_count' => $v['view_count'].'(avg: '.sprintf("%.2f",(int)$v['view_count']/$days).')',
                'historical_sold' => $v['historical_sold'].'(avg: '.sprintf("%.2f",(int)$v['historical_sold']/$days).')',
                'sold' => $v['sold'],
                'ads_keyword' => $v['ads_keyword'],
                'images' => $imgList
            ];

            $goodsList[] = $temp;
        }

        $data['avgPrice'] = sprintf('%.2f', ($totalPrice/100000)/count($arr['items']));
        $data['avgSold'] = sprintf('%.2f', $totalSold/$data['total_count']);
        $data['count_sold'] = $totalSold;

//        echo '<pre>';
//        print_r($data);
//        print_r($goodsList);
//        echo '</pre>';die();

        return JsonUtil::success([
            'goodsList' => $goodsList,
            'info' => $data
        ]);
    }
}