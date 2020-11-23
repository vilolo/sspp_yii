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
        //https://shopee.com.my/api/v2/search_items/?by=sales&keyword=anime&limit=50&newest=0&order=desc&page_type=search&version=2
        //https://xiapi.xiapibuy.com/api/v2/search_items/?by=sales&keyword=文具&limit=50&newest=0&order=desc&page_type=search&version=2
        //https://th.xiapibuy.com/api/v2/search_items/?by=sales&keyword=bag&limit=50&newest=0&order=desc&page_type=search&version=2
        //https://br.xiapibuy.com/api/v2/search_items/?by=sales&keyword=bag&limit=50&newest=0&order=desc&page_type=search&version=2

//        $itemBaseUrl = 'https://shopee.com.my/';

        $urlList = [
            'my' => 'https://shopee.com.my/',
            'tw' => 'https://xiapi.xiapibuy.com/',
            'th' => 'https://th.xiapibuy.com/',
            'br' => 'https://br.xiapibuy.com/',
        ];

        $params = '';

        //&maxPrice=50&minPrice=10
        $maxPrice = \Yii::$app->request->get('maxPrice');
        $minPrice = \Yii::$app->request->get('minPrice');
        if ($maxPrice > 0){
            $params .= '&price_max='.$maxPrice;
        }
        if ($maxPrice > 0){
            $params .= '&price_min='.$minPrice;
        }

        $itemBaseUrl = $urlList[\Yii::$app->request->get('store')]??'';
        if (!$itemBaseUrl){
            return JsonUtil::error('get url error');
        }

        $keyword = urlencode(\Yii::$app->request->get('keyword'));
        $header = array('User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');

        if (\Yii::$app->request->get('type') == 1) {

            $url = $itemBaseUrl."api/v2/search_items/?by=sales&keyword={$keyword}&limit=100&newest=0&order=desc&page_type=search&version=2".$params;
            $res = $this->curlGet($url, $header);
        }else{
            $url = $itemBaseUrl."api/v4/shop/get_shop_detail?username=".$keyword;
            $res = $this->curlGet($url, $header);
            $res = json_decode($res, true);
            sleep(1);
            $url = $itemBaseUrl."api/v2/search_items/?by=sales&limit=100&match_id={$res['data']['shopid']}&newest=0&order=desc&page_type=shop&version=2".$params;
            $res = $this->curlGet($url, $header);
        }

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
        $realTotalPrice = 0;
        $goodsList = [];
        if (!$arr['items']){
            return JsonUtil::error('数据未获取到:'.print_r($arr, true));
        }
        foreach ($arr['items'] as $k => $v){
            $totalSold += (int)$v['sold'];
            $totalPrice += (int)$v['price'];
            $realTotalPrice += (int)$v['price']*(int)$v['sold'];
            //url，标题，价格，上架时间，天数，点赞数（平均），观看数（平均），历史销量（平均），最近销量，图片
            $days = (int)(time() - (int)$v['ctime'])/86400;
            $days = $days <=0 ? 1 : $days;
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
                'liked_count' => $v['liked_count'],
                'liked_count_avg' => sprintf("%.2f",(int)$v['liked_count']/$days),
                'view_count' => $v['view_count'],
                'view_count_avg' => sprintf("%.2f",(int)$v['view_count']/$days),
                'historical_sold' => $v['historical_sold'],
                'historical_sold_avg' => sprintf("%.2f",(int)$v['historical_sold']/$days),
                'sold' => $v['sold'],
                'ads_keyword' => $v['ads_keyword'],
                'images' => $imgList,
                'shop_location' => $v['shop_location'],
            ];

            $goodsList[] = $temp;
        }

        $data['avgPrice'] = count($arr['items']) > 0 ? sprintf('%.2f', ($totalPrice/100000)/count($arr['items'])) : 0;
        $data['avgSold'] = $data['total_count'] > 0 ? sprintf('%.2f', $totalSold/$data['total_count']) : 0;
        $data['count_sold'] = $totalSold;
        $data['realAvgPrice'] = $totalSold > 0 ? sprintf('%.2f', ($realTotalPrice/100000)/$totalSold) : 0;

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