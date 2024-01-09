<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 10/06/2019
 * Time: 11:17
 */
namespace Payment\Interfaces;

use Payment\Model\BaseResponse;

interface PaymentSystemInterface
{
    public function generateForm(int $paymentSum, int $paymentId, string $paymentText);
    public function checkRequest(\CI_Input $CI_Input) : BaseResponse;
}