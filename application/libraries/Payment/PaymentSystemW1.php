<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 08/06/2019
 * Time: 18:50
 */
namespace Payment;
use Payment\Interfaces\PaymentSystemInterface;
use Payment\Model\BaseRequest;
use Payment\Model\BaseResponse;

/*
- контроллер
-- адаптер (Payment)
--- w1
--- webmoney (EntityWebmoney BaseEntity)
--- яндекс
---- PaymentInterface
*/


class PaymentW1Request extends BaseRequest {
    public $currencyCode, $description;
}

class PaymentW1Response extends BaseResponse {
    public $paymentType, $description, $signature, $printMessage;

}

class PaymentSystemW1 extends PaymentSystemBase implements PaymentSystemInterface
{
    private $request, $response;

    public function __construct()
    {
        parent::__construct();

        $this->request = new PaymentW1Request();
        $this->response = new PaymentW1Response();

        // Set merchant auth data
        $config = $this->CI->config->item('w1');
        $this->merchantUrl = $config['merchantUrl'];
        $this->merchantId = $config['merchantId'];
        $this->merchantPrivateKey = $config['merchantPrivateKey'];

        // Set default currencyCode
        $this->setCurrencyCode(643);

    }

    public function printAnswer($result, $description, $return = false)
    {
        $message  = "WMI_RESULT=" . strtoupper($result) . "&";
        $message .= "WMI_DESCRIPTION=" .urlencode($description);

        if($return)
        {
            return $message;
        }
        else
        {
            print $message;
        }

        exit();
    }

    public function setCurrencyCode($currencyCode)
    {
        $this->request->currencyCode = (int) $currencyCode;
    }

    public function generateForm(int $paymentSum, int $paymentId, string $paymentText)
    {

        $paymentText = 'Payment for ytuber.ru';

        // Добавление полей формы в ассоциативный массив
        $fields = [
            'WMI_MERCHANT_ID'       => $this->merchantId,
            'WMI_PAYMENT_AMOUNT'    => number_format($paymentSum, 2, '.', ''),
            'WMI_CURRENCY_ID'       => $this->request->currencyCode,
            'WMI_PAYMENT_NO'        => $paymentId,
            'WMI_DESCRIPTION'       => 'BASE64:'. base64_encode($paymentText),
            'WMI_EXPIRED_DATE'      => date('Y-m-d\TH:i:s', time()+86400*3),
            'WMI_SUCCESS_URL'       => $this->successUrl,
            'WMI_FAIL_URL'          => $this->failUrl
        ];

        //Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
        //$fields["WMI_PTENABLED"]      = array("UnistreamRUB", "SberbankRUB", "RussianPostRUB");

        //Сортировка значений внутри полей
        foreach($fields as $name => $val) {
            if(is_array($val)) {
                usort($val, "strcasecmp");
                $fields[$name] = $val;
            }
        }

        // Формирование сообщения, путем объединения значений формы,
        // отсортированных по именам ключей в порядке возрастания.
        uksort($fields, "strcasecmp");
        $fieldValues = "";

        foreach($fields as $value) {
            if(is_array($value))
                foreach($value as $v) {
                    //Конвертация из текущей кодировки (UTF-8)
                    //необходима только если кодировка магазина отлична от Windows-1251
                    $v = iconv("utf-8", "windows-1251", $v);
                    $fieldValues .= $v;
                }
            else {
                //Конвертация из текущей кодировки (UTF-8)
                //необходима только если кодировка магазина отлична от Windows-1251
                $value = iconv("utf-8", "windows-1251", $value);
                $fieldValues .= $value;
            }
        }

        // Формирование значения параметра WMI_SIGNATURE, путем
        // вычисления отпечатка, сформированного выше сообщения,
        // по алгоритму MD5 и представление его в Base64

        $signature = $this->generateSignature($fieldValues);

        //Добавление параметра WMI_SIGNATURE в словарь параметров формы
        $fields["WMI_SIGNATURE"] = $signature;

        // Формирование HTML-кода платежной формы
        $form = "<form action='https://wl.walletone.com/checkout/checkout/Index' method='POST' accept-charset='UTF-8'>";

        foreach($fields as $key => $val) {
            if(is_array($val))
                foreach($val as $value) {
                    $form .= "<input type='hidden' name='$key' value='$value'/>\r\n";
                }
            else
                $form .= "<input type='hidden' name='$key' value='$val'/>\r\n";
        }

        $form .= "[submit]</form>";

        return $form;
    }

    private function extractParams(\CI_Input $CI_Input)
    {
        $params = array();

        // Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE
        foreach($CI_Input->post() as $name => $value)
        {
            if ($name !== "WMI_SIGNATURE") $params[$name] = $value;
        }

        return $params;
    }

    private function sortParams($params)
    {
        // Сортировка массива по именам ключей в порядке возрастания
        // и формирование сообщения, путем объединения значений формы
        uksort($params, "strcasecmp"); $values = "";

        foreach($params as $name => $value)
        {
            //Конвертация из текущей кодировки (UTF-8)
            //необходима только если кодировка магазина отлична от Windows-1251
            $value = iconv("utf-8", "windows-1251", $value);
            //if (strlen($value) > 500) $value = substr($value, 0, 500);
            $values .= $value;
        }

        return $values;
    }

    private function generateSignature($values)
    {
        return base64_encode(pack("H*", md5($values . $this->merchantPrivateKey)));
    }

    public function checkRequest(\CI_Input $CI_Input): BaseResponse
    {
        // Проверка наличия необходимых параметров в POST-запросе
        if (!$CI_Input->post("WMI_SIGNATURE"))
            $this->printAnswer("Retry", "Отсутствует параметр WMI_SIGNATURE");

        if (!$CI_Input->post("WMI_PAYMENT_NO"))
            $this->printAnswer("Retry", "Отсутствует параметр WMI_PAYMENT_NO");

        if (!$CI_Input->post("WMI_ORDER_STATE"))
            $this->printAnswer("Retry", "Отсутствует параметр WMI_ORDER_STATE");


        // Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE
        $params = $this->extractParams($CI_Input);

        // Сортировка параметров
        $values = $this->sortParams($params);


        //log_message('error', 'WMI_DESCRIPTION: ' . iconv("utf-8", "windows-1251", $_POST['WMI_DESCRIPTION']));
        //log_message('error', 'W1 values: ' . $values);

        // Формирование подписи для сравнения ее с параметром WMI_SIGNATURE
        $signature = $this->generateSignature($values);

        // Log
        //log_message('error', 'W1 POST WMI_SIGNATURE: ' . $_POST['WMI_SIGNATURE'] . ', WMI_SIGNATURE: ' . $signature);

        //Сравнение полученной подписи с подписью W1

        if ($signature == $_POST["WMI_SIGNATURE"])
        {
            if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED")
            {

                $response = new PaymentW1Response();

                $response->paymentId     = $CI_Input->post('WMI_PAYMENT_NO');
                $response->paymentSum    = $CI_Input->post('WMI_PAYMENT_AMOUNT');
                $response->paymentStatus = TRUE;
                $response->paymentType   = $CI_Input->post('WMI_PAYMENT_TYPE');
                $response->description   = $CI_Input->post('WMI_DESCRIPTION');
                $response->signature     = $signature;
                $response->printMessage  = $this->printAnswer("Ok", "Заказ оплачен!", true);

                return $response;

                //$this->printAnswer("Ok", "Заказ оплачен!");
            } else
            {
                // Случилось что-то странное, пришло неизвестное состояние заказа
                $this->printAnswer("Retry", "Неверное состояние " . $_POST["WMI_ORDER_STATE"]);
            }
        } else
        {
            // Подпись не совпадает, возможно вы поменяли настройки интернет-магазина
            $this->printAnswer("Retry", "Неверная подпись " . $_POST["WMI_SIGNATURE"]);
        }

    }
}