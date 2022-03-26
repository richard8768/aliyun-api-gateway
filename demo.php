<?php

use Richard\AliyunApiGateway\Constant\ContentType;
use Richard\AliyunApiGateway\Constant\HttpHeader;
use Richard\AliyunApiGateway\Constant\HttpMethod;
use Richard\AliyunApiGateway\Constant\SystemHeader;
use Richard\AliyunApiGateway\Http\HttpClient;
use Richard\AliyunApiGateway\Http\HttpRequest;

// for more detail to see https://market.aliyun.com/products/57124001/cmapi022273.html?spm=5176.2020520132.101.9.2399721873IWAc#sku=yuncode1627300000
$deliveryCompanySn = 'your delivery company sn ';
$host = 'http://kdwlcxf.market.alicloudapi.com';
$path = '/kdwlcx';
$appkey = 'your app key ';
$appsecret = 'your app secret ';

$request = new HttpRequest($host, $path, HttpMethod::GET, $appkey, $appsecret);
//设定Content-Type，根据服务器端接受的值来设置
$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_TEXT);
//设定Accept，根据服务器端接受的值来设置
$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_TEXT);
//如果是调用测试环境请设置
//$request->setHeader(SystemHeader::X_CA_STAG, "TEST");
//注意：业务header部分，如果没有则无此行(如果有中文，请做Utf8ToIso88591处理)
//$request->setHeader("b-header2", mb_convert_encoding("headervalue2中文", "ISO-8859-1", "UTF-8"));
//$request->setHeader("a-header1", "headervalue1");
//注意：业务query部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
$request->setQuery("no", $deliveryCompanySn);
//指定参与签名的header
$request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
//$request->setSignHeader("a-header1");
//$request->setSignHeader("b-header2");
$response = HttpClient::execute($request);
//var_dump($response);
if (empty($response)) {
    throw new \Exception('未处理的异常,API接口调用错误');
}
$header = $response->getHeader();
$body = $response->getBody();
$httpCode = $response->getHttpStatusCode();
$body = json_decode($body, true);
var_dump($header, $body);
if ($httpCode !== 200) {
    if ($httpCode == 400 && strpos($header, "Invalid Param Location") !== false) {
        throw new \Exception("参数错误");
    } elseif ($httpCode == 400 && strpos($header, "Invalid AppCode") !== false) {
        throw new \Exception("AppCode错误");
    } elseif ($httpCode == 400 && strpos($header, "Invalid Url") !== false) {
        throw new \Exception("请求的 Method、Path 或者环境错误");
    } elseif ($httpCode == 403 && strpos($header, "Unauthorized") !== false) {
        throw new \Exception("服务未被授权（或URL和Path不正确）");
    } elseif ($httpCode == 403 && strpos($header, "Quota Exhausted") !== false) {
        throw new \Exception("套餐包次数用完");
    } elseif ($httpCode == 403 && strpos($header, "Api Market Subscription quota exhausted") !== false) {
        throw new \Exception("套餐包次数用完，请续购套餐");
    } elseif ($httpCode == 500) {
        throw new \Exception("API网关错误");
    } elseif ($httpCode == 0) {
        throw new \Exception("URL错误");
    } else {
        throw new \Exception("参数名错误 或 其他错误" . httpCode . "");
        $headers = explode("\r\n", $header);
        $headList = array();
        foreach ($headers as $head) {
            $value = explode(':', $head);
            $headList[$value[0]] = $value[1];
        }
        throw new \Exception($headList['x-ca-error-message']);
    }
}
if (!empty($body['status'])) {
    throw new \Exception('物流查询发生错误:' . $body['msg'] . '');
}
$result = $body['result'];
var_dump($result);