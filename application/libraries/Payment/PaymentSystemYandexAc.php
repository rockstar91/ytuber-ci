<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16/06/2019
 * Time: 20:59
 */

namespace Payment;


class PaymentSystemYandexAc extends PaymentSystemYandex
{
    public function __construct()
    {
        parent::__construct('AC');
		$this->paymentSumRatio = 1.021;
    }
}