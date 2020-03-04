<?php
/**
 * File: payjs.php
 * Functionality: payjs
 * Author: Traceless
 * Date: 2020年3月4日 11:56:09
 */

namespace Pay\payjswx;

use \Pay\notify;

class payjswx
{
    private $paymethod = "payjswx";

    private $payjs_native_url = 'https://payjs.cn/api/cashier?';

    //处理请求
    public function pay($payconfig, $params)
    {
        clearstatcache();
        $data         = [
            'mchid'        => $payconfig['app_id'],
            'body'         => $params['orderid'],
            'out_trade_no' => $params['orderid'],
            'total_fee'    => $params['money'] * 100,
            'notify_url'   => $params['weburl'] . 'product/notify/?paymethod='.$this->paymethod,
		    'callback_url' => $params['payjsredicurl'] ,
		    'logo'		   => $params['payjspagelogo'] ,
		    'auto'		   => '1'
			
        ];
        $this->key    = $payconfig['app_secret'];
        $data['sign'] = $this->sign($data);
		
		// 浏览器跳转到收银台
		//$url = 'https://payjs.cn/api/cashier?' . 'mchid=' . $payconfig['app_id'] . '&out_trade_no=' . $data['out_trade_no'] . '&total_fee'. $data['total_fee']. '&total_fee'. $data['total_fee'] . '$notify_url=' . $data['notify_url'];
		$url = $this->payjs_native_url . http_build_query($data);

        //$result = $this->post($data, $this->payjs_native_url);
        //$result = json_decode($result, true);
		
        $result_params = [
            'type'      => 0,
            'subjump'   => 0,
            'paymethod' => $this->paymethod,
            'qr'        => $params['qrserver'] . urlencode($url),
            'payname'   => $payconfig['payname'],
            'overtime'  => $payconfig['overtime'],
            'money'     => $params['money'],
			'msg'		=> $url
        ];

        return ['code' => 1, 'msg' => 'success', 'data' => $result_params];
    }

    public function notify()
    {
        $data = $_POST;

        if ($data['return_code'] == 1) {
            $config = [
                'paymethod' => $this->paymethod,
                'tradeid'   => $data['payjs_order_id'],
                'paymoney'  => $data['total_fee'] / 100,
                'orderid'   => $data['out_trade_no'],
            ];
            $notify = new \Pay\notify();
            $notify->run($config);
        }

        return 'success';
    }

    public function post($data, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $rst = curl_exec($ch);
        curl_close($ch);
        return $rst;
    }

    public function sign(array $attributes)
    {
        ksort($attributes);
        $sign = strtoupper(md5(urldecode(http_build_query($attributes)) . '&key=' . $this->key));
        return $sign;
    }

}
