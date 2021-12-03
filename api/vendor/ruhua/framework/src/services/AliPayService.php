<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/8/6 0006
 * Time: 15:50
 */

namespace ruhua\services;

use think\facade\Log;

require ROOT . '/../extend/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
require ROOT . '/../extend/alipay/wappay/service/AlipayTradeService.php';
require ROOT . '/../extend/alipay/aop/AopClient.php';

class AliPayService
{
    public function pay($data)
    {

        $out_trade_no = $data['order_num'];
        $total_amount = $data['order_money'];
        $aop=new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = config('setting.zfb_appid');
        $aop->rsaPrivateKey=config('setting.zfb_private_key');
        $aop->alipayrsaPublicKey=config('setting.zfb_public_key');
        $aop->apiVersion = '1.0';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $aop->signType='RSA2';
        $request=new \AlipayTradeWapPayRequest();
        $request->setBizContent("{" .
            "    \"body\":\"\"," .
            "    \"subject\":\"订单支付\"," .
            "    \"out_trade_no\":\"$out_trade_no\"," .
            "    \"timeout_express\":\"90m\"," .
            "    \"total_amount\":$total_amount," .
            "    \"product_code\":\"QUICK_WAP_WAY\"" .
            "  }");

        $zfb_back=config('setting.zfb_back');
        $request->setNotifyUrl($zfb_back);
        $request->setReturnUrl($zfb_back);
        $result = $aop->pageExecute($request);
        return $result;
    }


    public function appPay($data)
    {

        $out_trade_no = $data['order_num'];
        $total_amount = $data['order_money'];

        $aop=new \AopClient();

        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId =config('setting.zfb_appid');
        $aop->rsaPrivateKey=config('setting.zfb_private_key');
        $aop->format = "json";
        $aop->apiVersion="1.0";
        $aop->postCharset = "utf-8";
        $aop->signType = "RSA2";

        $aop->alipayrsaPublicKey = config('setting.zfb_public_key');
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request=new \AlipayTradeAppPayRequest();

        $request->setNotifyUrl(config('setting.zfb_back'));

        $request->setBizContent("{" .
            "    \"body\":\"pay\"," .
            "    \"subject\":\"pay\"," .
            "    \"out_trade_no\":\"$out_trade_no\"," .
            "    \"timeout_express\":\"30m\"," .
            "    \"total_amount\":$total_amount," .
            "    \"product_code\":\"QUICK_MSECURITY_PAY\"" .
            "  }");
        $response = $aop->sdkExecute($request);

        return $response;
        // return htmlspecialchars($response);
    }
}