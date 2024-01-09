<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 13/06/2019
 * Time: 11:57
 */

namespace Payment;

use Payment\Interfaces\PaymentSystemInterface;

use Payment\Model\BaseRequest;
use Payment\Model\BaseResponse;

class PaymentTestRequest extends BaseRequest {
    public $currencyCode, $description;
}

class PaymentTestResponse extends BaseResponse {
    public $paymentType, $description;

}

class PaymentSystemTest extends PaymentSystemBase implements PaymentSystemInterface
{

    private $request, $response;

    public function __construct()
    {
        parent::__construct();

        $this->request = new PaymentTestRequest();
        $this->response = new PaymentTestResponse();
    }

    public function generateForm(int $paymentSum, int $paymentId, string $paymentText)
    {
        // TODO: Implement generateForm() method.
    }

    public function checkRequest(\CI_Input $CI_Input): BaseResponse
    {
        // TODO: Implement checkRequest() method.

        $response = new PaymentTestResponse();
        $response->paymentId = $CI_Input->post('payment_id');
        $response->paymentSum = $CI_Input->post('payment_sum');
        $response->paymentStatus = true;

        return $response;
    }
}