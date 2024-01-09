<?php

namespace Payment;
use Payment\Interfaces\PaymentSystemInterface;
use Payment\Model\BaseRequest;
use Payment\Model\BaseResponse;

class PaymentUnitPayRequest extends BaseRequest {
    public $currencyCode, $description;
}

class PaymentUnitPayResponse extends BaseResponse {
    public $paymentType, $description, $signature, $printMessage;

}

class PaymentSystemUnitPay extends PaymentSystemBase implements PaymentSystemInterface
{
    private $request, $response;

    public function __construct()
    {
        parent::__construct();

        $this->request = new PaymentunitpayRequest();
        $this->response = new PaymentunitpayResponse();

        // Set merchant auth data
        $config = $this->CI->config->item('unitpay');
        $this->merchantUrl = $config['merchantUrl'];
        $this->merchantId = $config['merchantId'];
        $this->merchantPrivateKey = $config['merchantPrivateKey'];

        // Set default currencyCode
        $this->setCurrencyCode(643);
    }

    public function setCurrencyCode($currencyCode)
    {
        $this->request->currencyCode = (int) $currencyCode;
    }

    public function generateForm(int $paymentSum, int $paymentId, string $paymentText)
    {		
		$orderId        = $paymentId;
        $orderSum       = $paymentSum;
        $orderDesc      = $paymentText;
        $orderCurrency  = 'RUB';
		$projectId      = $this->merchantId;
		
		$unitPay = new \UnitPay($this->merchantPrivateKey);
		
		
		$unitPay
			->setBackUrl(site_url('payment/success'));
		
		$redirectUrl = $unitPay->form(
			$this->merchantId,
			$orderSum,
			$orderId,
			$orderDesc,
			$orderCurrency,
			$projectId
		);
		
		log_message('error', 'redirectURL: '. $redirectUrl);
		
		// Формирование HTML-кода платежной формы
        $form = "<form action='".$redirectUrl."' method='POST' accept-charset='UTF-8'>";
        $form .= "[submit]</form>";

        return $form;
    }

    private function generateSignature($method, $params) 
	{
		ksort($params);
		unset($params['sign']);
		unset($params['signature']);
		array_push($params, $this->merchantPrivateKey);
		array_unshift($params, $method);
		
		return hash('sha256', join('{up}', $params));
    }

    public function checkRequest(\CI_Input $CI_Input): BaseResponse
    {
		$unitPay = new \UnitPay($this->merchantPrivateKey);

		try 
		{
			$unitPay->checkHandlerRequest();

			list($method, $params) = array($_GET['method'], $_GET['params']);
			
			log_message('error', 'UnitPay: '. serialize($params));
			log_message('error', 'Signature: '. $unitPay->getSignature($_GET['params'], $method));
			
			/*if (
				$params['orderSum'] != paymentSum ||
				$params['orderCurrency'] != 'RUB' ||
				$params['account'] != paymentId ||
				$params['projectId'] != $this->merchantId
				
			) {
				// logging data and throw exception
				throw new InvalidArgumentException('Order validation Error!');
			}*/
			
			$response = new BaseResponse();
			$response->paymentId = (int)$params['orderId'];
			$response->paymentSum = $params['orderSum'];
			$response->paymentStatus = FALSE;
			$response->signature = $params['signature'];

			switch ($method) {
				
				// Проверяется только заказ (проверяется статус сервера, заказа в БД)
				case 'check':
					echo $unitPay->getSuccessHandlerResponse('Check Success. Ready to pay.');
			    	//return $response;
					break;
				// Оплата прошла успешно
				case 'pay':	
					$response->paymentStatus = TRUE;
			    	return $response;

				case 'error':	
					echo $unitPay->getSuccessHandlerResponse('Ошибка оплаты');
			    	//return $response;
					break;
			}	
		} catch (Exception $e) {
			echo $unitPay->getErrorHandlerResponse($e->getMessage());
		}
    }
}