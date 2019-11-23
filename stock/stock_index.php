<?php
/**
 * Created by PhpStorm.
 * User: Hushengs
 * Date: 2017/5/17
 * Time: 11:01
 */
$ch = curl_init();
$url_sh = 'http://hq.sinajs.cn/list=s_sh000001';
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
curl_setopt($ch , CURLOPT_URL , $url_sh);
$res_sh = curl_exec($ch);
$arr_val_inner_1 = explode('=',$res_sh);
$ch = curl_init();
$url_sz = 'http://hq.sinajs.cn/list=s_sz399001';
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行HTTP请求
curl_setopt($ch , CURLOPT_URL , $url_sz);
$res_sz = curl_exec($ch);
$arr_val_inner_2 = explode('=',$res_sz);
$arr_val_inner = array_merge($arr_val_inner_1,$arr_val_inner_2);
foreach($arr_val_inner as $arr_val_1)
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
    $arr_return[$str_key]['now_point'] = $arr_last[1];
    $arr_return[$str_key]['now_change'] = $arr_last[2];
    $arr_return[$str_key]['now_change_centage'] = $arr_last[3];
    $arr_return[$str_key]['bargain_num'] = $arr_last[4];
    $arr_return[$str_key]['bargain_total_money'] = strstr($arr_last[5],'"',true);
//    $arr_return[$str_key]['bargain_total_money'] = rtrim($arr_last[5],';"');
    unset($str_key);
}
echo json_encode($arr_return);