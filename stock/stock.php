<?php
/**
 * Created by PhpStorm.
 * User: Hushengs
 * Date: 2017/5/17
 * Time: 2:20
 */
//股票实时价格api
include dirname(__FILE__).'/config.php';
    $ch = curl_init();
    $url_g = 'http://hq.sinajs.cn/list='.$str;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url_g);
    $res = curl_exec($ch);
    $arr_result = explode(';',$res);
    $today_total_profit_and_loss = 0;
    foreach($arr_result as $arr_val)
    {
        $arr_val_inner = explode('=',$arr_val);
        foreach($arr_val_inner as $key=>$arr_val_1)
        {
            if(strpos($arr_val_1,'hq_str_'))
            {
                $str_key = strstr($arr_val_1,'hq_str_');
                continue;
            }
            $arr_last = explode(',',$arr_val_1);
            if(!is_array($arr_last) || empty($str_key))
            {
                continue;
            }
            $arr_return[$str_key]['name'] = ltrim(iconv('GBK','UTF-8',$arr_last[0]),'"');
            $arr_return[$str_key]['opening_price'] = $arr_last[1];
            $arr_return[$str_key]['closing_price'] = $arr_last[2];
            $arr_return[$str_key]['now_price'] = $arr_last[3];
            $arr_return[$str_key]['highest_price'] = $arr_last[4];
            $arr_return[$str_key]['lowest_price'] = $arr_last[5];
            $arr_return[$str_key]['change_price'] = round($arr_last[3]-$arr_last[2],3);
            $arr_return[$str_key]['range'] = round(($arr_last[3]-$arr_last[2])/$arr_last[2]*100,2)."%";
            $arr_return[$str_key]['profit_and_loss'] = $arr_return[$str_key]['change_price']*$arr_num[$str_key];
            $today_total_profit_and_loss +=$arr_return[$str_key]['profit_and_loss'];
            unset($str_key);
        }
    }
    $arr_return['today_profit_and_loss'] = $today_total_profit_and_loss;
echo json_encode($arr_return);
//echo json_encode($arr_return['today_profit_and_loss']);