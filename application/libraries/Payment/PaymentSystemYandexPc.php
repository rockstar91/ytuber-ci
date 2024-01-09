<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16/06/2019
 * Time: 21:35
 */

namespace Payment;


class PaymentSystemYandexPc extends PaymentSystemYandex
{
    public function __construct()
    {
        parent::__construct('PC');
        $this->paymentSumRatio = 1.005;
    }
}