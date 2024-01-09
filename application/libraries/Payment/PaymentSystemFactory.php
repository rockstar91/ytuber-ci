<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 10/06/2019
 * Time: 13:04
 */

namespace Payment;

use Payment\Interfaces\PaymentSystemInterface;

class PaymentSystemFactory
{
    static function createSystemByClassName($system) : PaymentSystemBase
    {
        $className = __NAMESPACE__ . '\\' . 'PaymentSystem' . $system;

        if(class_exists($className))
        {
            return new $className();
        }
        else {
            $errorMessage = 'Cannot create new "' . $className . '" class - includes not found or class unavailable.';
            throw new Exception\BaseException($errorMessage);
        }
    }

    /*
    static function createSystemByMethodName($system) : PaymentSystemBase
    {
        if(method_exists('PaymentSystemFactory', $system))
        {
            return self::$system();
        }
    }
    */

    static function createSystem(string $system) : PaymentSystemBase
    {
        return self::createSystemByClassName($system);
    }

    /*
    static function W1() : PaymentSystemInterface
    {
        return new PaymentSystemW1();
    }

    static function YandexAc()
    {

    }

    static function YandexBc()
    {

    }

    static function Webmoney()
    {

    }

    static function Test()
    {
        return new PaymentSystemTest();
    }
    */
}