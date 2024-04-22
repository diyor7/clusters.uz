<?php

/**
 * Created by PhpStorm.
 * User: Muxtorov Ulugbek
 * Date: 05.12.2019
 * Time: 0:45
 */

namespace common\components;


use yii\base\Component;
use Yii;

class MyCurl extends Component
{
    /**
     * For banking
     * @param $link
     * @param string $contentType
     * @param string $method
     * @param null $data
     * @return mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public static function request($link, $contentType = 'application/xml', $method = 'GET', $data = null)
    {
        $headers = [
            'Content-Type:' . $method == 'POST' ? 'application/x-www-form-urlencoded' : $contentType,
            'Accept:' . $contentType,
        ];

        //Определим на наличие GET param
        if (strpos($link, '?') === false) {
            $ampersant = '?';
        } else {
            $ampersant = '&';
        }

        $url = Yii::$app->params['banking_host'] . $link . $ampersant .
            'access-token=' . Yii::$app->params['banking_token'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Yii::$app->params['banking_username'] . ":" . Yii::$app->params['banking_password']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);

        //Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $contentType == 'application/xml' ? simplexml_load_string($return) : json_decode($return);
    }

    public static function requestRtsb($link, $data = null, $contentType = 'application/json', $method = 'POST')
    {
        $headers = [
            'Content-Type:' . $contentType,
            'Accept:' . $contentType,
            'Authorization: ' . Yii::$app->params['rtsb_credential'],
            'Content-Length: ' . strlen($data),
        ];

        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_USERPWD, Yii::$app->params['banking_username'] . ":" . Yii::$app->params['banking_password']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);

        //Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $contentType == 'application/xml' ? simplexml_load_string($return) : json_decode($return);
    }

    /**
     * For statistics
     * @param $link
     * @param string $contentType
     * @param string $method
     * @param null $data
     * @return mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public static function requestStat($link, $contentType = 'application/xml', $method = 'GET', $data = null)
    {
        $headers = [
            'Content-Type:' . $method == 'POST' ? 'application/x-www-form-urlencoded' : $contentType,
            'Accept:' . $contentType,
        ];

        //Определим на наличие GET param
        if (strpos($link, '?') === false) {
            $ampersant = '?';
        } else {
            $ampersant = '&';
        }

        $url = Yii::$app->params['stat_host'] . $link . $ampersant .
            'access-token=' . Yii::$app->params['stat_token'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Yii::$app->params['stat_username'] . ":" . Yii::$app->params['stat_password']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $getted = curl_exec($ch);

        //Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        if ($contentType == 'application/xml') {
            libxml_use_internal_errors(TRUE); // this turns off spitting errors on your screen
            try {
                //simplexml_load_string($getted)
                $xml = simplexml_load_string($getted); //new \SimpleXMLElement($getted);
            } catch (\Exception $e) {
                echo $getted;
                $xml = self::requestStat($link, $contentType, $method, $data);
                // Do something with the exception, or ignore it.
            }
            return $xml;
        } else {
            return json_decode($getted);
        }
    }

    /**
     * For backend banking
     * @param $link
     * @param string $contentType
     * @param string $method
     * @param null $data
     * @return mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public static function rkp($link, $contentType = 'application/json', $method = 'GET', $data = null)
    {
        $headers = [
            'Content-Type:' . $method == 'POST' ? 'application/x-www-form-urlencoded' : $contentType,
            'Accept:' . $contentType,
        ];

        //Определим на наличие GET param
        if (strpos($link, '?') === false) {
            $ampersant = '?';
        } else {
            $ampersant = '&';
        }

        $url = Yii::$app->params['banking_host'] . $link . $ampersant .
            'access-token=' . Yii::$app->params['banking_token'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, Yii::$app->params['banking_username'] . ":" . Yii::$app->params['banking_password']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);

        //Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $contentType == 'application/xml' ? simplexml_load_string($return) : json_decode($return, true);
    }

    /**
     * For backend banking
     * @param $link
     * @param string $contentType
     * @param string $method
     * @param null $data
     * @return mixed|\SimpleXMLElement
     * @throws \Exception
     */
    public static function esp($link, $contentType = 'application/json', $method = 'POST', $data = null)
    {
        $headers = [
            'Content-Type:' . $method == 'POST' ? 'application/x-www-form-urlencoded' : $contentType,
            'Accept:' . $contentType,
        ];

        $url = $link;

        $ch = curl_init($url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);

        //Check for errors.
        if (curl_errno($ch)) {
            //If an error occured, throw an Exception.
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $contentType == 'application/xml' ? simplexml_load_string($return) : json_decode($return, true);
    }
}
