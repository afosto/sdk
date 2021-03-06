<?php

namespace Paynl;

use Paynl\Api\Voucher as Api;
use Paynl\Result\Voucher as Result;

class Voucher
{


    /**
     * Return the voucher
     *
     * @param string $cardNumber
     * @return \Paynl\Result\Voucher\Voucher
     */
    public static function get($cardNumber)
    {
        $api = new Api\Balance();
        $api->setCardNumber($cardNumber);
        $result = $api->doRequest();
        return new Result\Voucher($result);
    }

    /**
     * Return the voucher
     *
     * @param string $cardNumber
     * @return float the current balance
     */
    public static function balance($options = [])
    {
        $api = new Api\Balance();

        if(isset($options['cardNumber'])){
            $api->setCardNumber($options['cardNumber']);
        }

        $result = $api->doRequest();
        return $result['balance'] / 100;

    }

    /**
     * Charge a voucher
     * @param array $options
     * @return bool if the charge was done succefully
     */
    public static function charge($options = [])
    {
        $api = new Api\Charge();

        if(isset($options['pincode'])){
            $api->setPincode($options['pincode']);
        }
        if(isset($options['cardNumber'])){
            $api->setCardNumber($options['cardNumber']);
        }
        if(isset($options['amount'])){
            $api->setAmount(round($options['amount'] * 100));
        }

        $result = $api->doRequest();

        return $result['request']['result'] == 1;

    }
}