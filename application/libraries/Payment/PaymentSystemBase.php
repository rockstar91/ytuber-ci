<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 10/06/2019
 * Time: 12:33
 */

namespace Payment;


class PaymentSystemBase
{
    protected $CI;

    protected $merchantUrl;
    protected $merchantId;
    protected $merchantPrivateKey;
    protected $successUrl;
    protected $failUrl;

    public function __construct()
    {
        $this->successUrl = site_url('payment/success');
        $this->failUrl = site_url('payment/fail');

        $this->getInstanceCI();
    }

    /**
     * Create instance of CodeIgniter
     */
    protected function getInstanceCI()
    {
        $this->CI =& get_instance();
    }
}