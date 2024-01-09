<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 16/06/2019
 * Time: 22:29
 */

namespace Payment;


use Payment\Interfaces\PaymentSystemInterface;
use Payment\Model\BaseRequest;
use Payment\Model\BaseResponse;

class PaymentSystemWebmoney extends PaymentSystemBase implements PaymentSystemInterface
{
    protected $roubleToWmzRate = 75.5;
    protected $recalculateFromRouble = true;
    protected $testMode = 0;

    public function __construct($paymentType = 'AC')
    {
        parent::__construct();

        $this->request = new BaseRequest();
        $this->response = new BaseResponse();

        // Set merchant auth data
        $config = $this->CI->config->item('webmoney');
        $this->merchantUrl = $config['merchantUrl'];
        $this->merchantId = $config['merchantId'];
        $this->merchantPrivateKey = $config['merchantPrivateKey'];

    }

    public function generateForm(int $paymentSum, int $paymentId, string $paymentText)
    {

        if($this->recalculateFromRouble) {
            $paymentSum = number_format($paymentSum / $this->roubleToWmzRate, 2);
        }

        $form  = '<form id=pay name=pay method="POST" action="' . $this->merchantUrl . '" accept-charset="windows-1251">';
        $form .= '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="' . $paymentSum . '"/>';
        $form .= '<input type="hidden" name="LMI_PAYMENT_DESC" value="' . $paymentText . '"/>';
        $form .= '<input type="hidden" name="LMI_PAYMENT_NO" value="' . $paymentId . '">';
        $form .= '<input type="hidden" name="LMI_PAYEE_PURSE" value="' . $this->merchantId . '"/>';
        $form .= '<input type="hidden" name="LMI_SIM_MODE" value="' . $this->testMode . '"/>';
        $form .= '[submit]';
        $form .= '</form>';

        return $form;
    }

    public function checkRequest(\CI_Input $CI_Input): BaseResponse
    {
        //$payee_purse = 'R384856904150';
        //$key = '345tersdft345afSADW543}WERL>we435';

        log_message('ínfo', 'Webmoney request received');

        $fields = array(
            'LMI_PAYEE_PURSE' => $_POST['LMI_PAYEE_PURSE'],
            'LMI_PAYMENT_AMOUNT' => $_POST['LMI_PAYMENT_AMOUNT'],
            'LMI_PAYMENT_NO' => $_POST['LMI_PAYMENT_NO'],
            'LMI_MODE' => $_POST['LMI_MODE'],
            'LMI_SYS_INVS_NO' => $_POST['LMI_SYS_INVS_NO'],
            'LMI_SYS_TRANS_NO' => $_POST['LMI_SYS_TRANS_NO'],
            'LMI_SYS_TRANS_DATE' => $_POST['LMI_SYS_TRANS_DATE'],
            'LMI_SECRET_KEY' => $this->merchantPrivateKey,
            'LMI_PAYER_PURSE' => $_POST['LMI_PAYER_PURSE'],
            'LMI_PAYER_WM' => $_POST['LMI_PAYER_WM'],
        );

        $values = '';

        foreach ($fields as $key => $value)
        {
            $values .= $value;
        }

        if ($_POST['LMI_MODE'] != 0)
        {
            die('LMI_MODE');
        }

        // Проверка номера кошелька
        if ($_POST['LMI_PAYEE_PURSE'] != $this->merchantId)
        {
            die('LMI_PAYEE_PURSE');
        }

        // Проверка сигнатуры
        $signature = strtoupper(hash('sha256', $values));
        if ($_POST['LMI_HASH'] != $signature)
        {
            log_message('error', 'LMI_HASH (' . $_POST['LMI_HASH'] . ') does not match with: ' . $signature);
            die('LMI_HASH');
        }


        $LMI_PAYMENT_AMOUNT = $_POST['LMI_PAYMENT_AMOUNT'];

        if($this->recalculateFromRouble) {
            $LMI_PAYMENT_AMOUNT = number_format($LMI_PAYMENT_AMOUNT * $this->roubleToWmzRate, 2);
        }

        $response = new BaseResponse();

        $response->paymentId = (int)$_POST["LMI_PAYMENT_NO"];
        $response->paymentSum = $LMI_PAYMENT_AMOUNT;
        $response->paymentStatus = TRUE;

        return $response;
    }
}