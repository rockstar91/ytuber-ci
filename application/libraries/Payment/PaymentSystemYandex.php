<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16/06/2019
 * Time: 20:46
 */

namespace Payment;


use Payment\Interfaces\PaymentSystemInterface;
use Payment\Model\BaseRequest;
use Payment\Model\BaseResponse;

class PaymentSystemYandex extends PaymentSystemBase implements PaymentSystemInterface
{

    protected $paymentSumRatio = 1;
    protected $paymentType;

    public function __construct($paymentType = 'AC')
    {
        parent::__construct();

        $this->request = new BaseRequest();
        $this->response = new BaseResponse();

        // Set merchant auth data
        $config = $this->CI->config->item('yandex');
        $this->merchantUrl = $config['merchantUrl'];
        $this->merchantId = $config['merchantId'];
        $this->merchantPrivateKey = $config['merchantPrivateKey'];

        // Set default paymentType
        $this->setPaymentType($paymentType);

    }

    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    public function generateForm(int $paymentSum, int $paymentId, string $paymentText)
    {
        $form  = '<form method="POST" action="' . $this->merchantUrl . '">';
        $form .= '<input type="hidden" name="receiver" value="' . $this->merchantId . '">';
        $form .= '<input type="hidden" name="formcomment" value="' . $paymentText . '">';
        $form .= '<input type="hidden" name="label" value="' . $paymentId . '">';
        $form .= '<input type="hidden" name="quickpay-form" value="shop">';
        $form .= '<input type="hidden" name="targets" value="' . $paymentText . '">';
        $form .= '<input type="hidden" name="paymentType" value="' . $this->paymentType . '">';
        $form .= '<input type="hidden" name="sum" value="' . $paymentSum * $this->paymentSumRatio . '">';
        $form .= '[submit]';
        $form .= '</form>';

        return $form;
    }

    public function checkRequest(\CI_Input $CI_Input): BaseResponse
    {
        // получение данных.
        $a = array(
            'withdraw_amount' => $CI_Input->post('withdraw_amount'),     // Сумма, которая списана со счета отправителя.
            'sha1_hash' => $CI_Input->post('sha1_hash'),                 // SHA-1 hash параметров уведомления.
            'unaccepted' => $CI_Input->post('unaccepted')
        );

        $b = array(
            'notification_type' => $CI_Input->post('notification_type'), // p2p-incoming / card-incoming - с кошелька / с карты
            'operation_id' => $CI_Input->post('operation_id'),           // Идентификатор операции в истории счета получателя.
            'amount' => $CI_Input->post('amount'),                       // Сумма, которая зачислена на счет получателя.
            'currency' => $CI_Input->post('currency'),                   // Код валюты — всегда 643 (рубль РФ согласно ISO 4217).
            'datetime' => $CI_Input->post('datetime'),                   // Дата и время совершения перевода.
            'sender' => $CI_Input->post('sender'),                       // Для переводов из кошелька — номер счета отправителя. Для переводов с произвольной карты — параметр содержит пустую строку.
            'codepro' => $CI_Input->post('codepro'),                     // Для переводов из кошелька — перевод защищен кодом протекции. Для переводов с произвольной карты — всегда false.
            'secret' => $this->merchantPrivateKey,
            'label' => $CI_Input->post('label'),                         // Метка платежа. Если ее нет, параметр содержит пустую строку.
        );

        if (sha1(implode('&', $b)) != $a['sha1_hash'])
        {
            // останавливаем скрипт. у вас тут может быть свой код.
            exit('Верификация не пройдена. SHA1_HASH не совпадает.');
        }

        if ($a['unaccepted'] == 'true')
        {
            exit('Платежи с протекцией будут обработаны в ручном режиме.');
        }

        $response = new BaseResponse();

        $response->paymentId = $CI_Input->post('label');
        $response->paymentSum = $CI_Input->post('amount');
        $response->paymentStatus = TRUE;

        return $response;
    }
}