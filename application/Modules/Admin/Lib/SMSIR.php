<?php

namespace Modules\Admin\Lib;

/**
 * VerificationCode File Restful API PHP Sample Codes
 *
 * PHP version 5.6.23 | 7.2.12
 *
 * @category  PHPSampleCodes
 * @package   SampleCodes

 * @copyright 2018 The Ide Pardazan (ipe.ir) PHP Group. All rights reserved.
 * @license   https://sms.ir/ ipe license

 * @version   IPE: 2.0
 * @link      https://sms.ir/ Documentation of sms.ir Restful API PHP Sample Codes.
 */

/**
 * VerificationCode Class Restful API PHP Sample Codes
 *
 * @category  PHPSampleCodesClass
 * @package   SampleCodesClass

 * @copyright 2018 The Ide Pardazan (ipe.ir) PHP Group. All rights reserved.
 * @license   https://sms.ir/ ipe license
 * @link      https://sms.ir/ Documentation of sms.ir
 */
class SMSIR
{

    /**
     * Gets API Verification Code Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIVerificationCodeUrl()
    {
        return "api/VerificationCode";
    }

    protected function getAPIUltraFastSendUrl()
    {
        return "api/UltraFastSend";
    }

    /**
     * Gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl()
    {
        return "api/Token";
    }

    /**
     * Gets config parameters for sending request.
     *
     * @param string $APIKey    API Key
     * @param string $SecretKey Secret Key
     * @param string $APIURL    API URL
     *
     * @return void
     */
    public function __construct()
    {
        $this->APIKey = env('SMS_IR_API_KEY');
        $this->SecretKey = env('SMS_IR_SEC_CODE');
        $this->APIURL = 'https://ws.sms.ir/';
    }

    /**
     * Verification Code.
     *
     * @param string $Code         Code
     * @param string $MobileNumber Mobile Number
     *

     * @return string Indicates the sent sms result
     */
    public function verificationCode($Code, $MobileNumber)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = array(
                'Code' => $Code,
                'MobileNumber' => $MobileNumber,
            );

            $url = $this->APIURL . $this->getAPIVerificationCodeUrl();
            $VerificationCode = $this->_execute($postData, $url, $token);
            $object = json_decode($VerificationCode);

            $result = false;
            if (is_object($object)) {
                $result = $object->Message;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function _getToken()

    {
        $postData = array(
            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_2_0'
        );
        $postString = json_encode($postData);

        $ch = curl_init($this->APIURL . $this->getApiTokenUrl());
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json'
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        $resp = false;
        $IsSuccessful = '';
        $TokenKey = '';
        if (is_object($response)) {
            $IsSuccessful = $response->IsSuccessful;
            if ($IsSuccessful == true) {
                $TokenKey = $response->TokenKey;
                $resp = $TokenKey;
            } else {
                $resp = false;
            }
        }
        return $resp;
    }

    /**
     * Executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string     $url      url
     * @param string     $token    token string
     *
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token)
    {
        $postString = json_encode($postData);

        $ch = curl_init($url);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'x-sms-ir-secure-token: ' . $token
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function ultraFastSend($data)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = $data;

            $url = $this->APIURL . $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->_execute($postData, $url, $token);
            $object = json_decode($UltraFastSend);

            $result = false;
            if (is_object($object)) {
                return  $object->IsSuccessful;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return  $object->IsSuccessful;
    }

    public static function send($code, $mobile, $verifyCode)
    {
        try {
            $data = array(
                "ParameterArray" => array(
                    array(
                        "Parameter" => "code",
                        "ParameterValue" => $verifyCode
                    )
                ),
                "Mobile" => $mobile,
                "TemplateId" => $code
            );
            $sms = new SMSIR();
            return $sms->ultraFastSend($data);
        } catch (\Exception $th) {
            return $th;
        }
    }

    public static function send2($code, $mobile, $param, $paramName)
    {
        try {
            $data = array(
                "ParameterArray" => array(
                    array(
                        "Parameter" => $paramName,
                        "ParameterValue" => $param
                    )
                ),
                "Mobile" => $mobile,
                "TemplateId" => $code
            );
            $sms = new SMSIR();
            return $sms->ultraFastSend($data);
        } catch (\Exception $th) {
            return $th;
        }
    }
}
