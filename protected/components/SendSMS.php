<?php
/**
 * Class SendSMS
 */
class SendSMS extends CComponent
{
    public $APIKey = "db6c1b9b35a09ca85721b9b";
    public $SecretKey = "!@#Rahbod1395";
    public $LineNumber = "30004505004844";
    public $APIURL = "https://ws.sms.ir/";

    public $messagePostfix = 'http://carcadeh.ir';
    private $_invalid_numbers = array();
    private $_numbers = array();
    private $_messages = array();

    /**
     * Send sms.
     *
     * @param [] $MobileNumbers array structure of mobile numbers
     * @param []      $Messages      array structure of messages
     * @param string $SendDateTime Send Date Time
     *
     * @return string Indicates the sent sms result
     */

    public function sendMessage()
    {
        $token = $this->_getToken();
        if ($token != false) {
            @$SendDateTime = date("Y-m-d") . "T" . date("H:i:s");
            $postData = array(
                'Messages' => $this->getMessages(),
                'MobileNumbers' => $this->getNumbers(),
                'LineNumber' => $this->LineNumber,
                'SendDateTime' => $SendDateTime,
                'CanContinueInCaseOfError' => 'false'
            );

            $url = $this->APIURL . $this->getAPIMessageSendUrl();
            $SendMessage = $this->_execute($postData, $url, $token);
            $object = json_decode($SendMessage);

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
            $ch, CURLOPT_HTTPHEADER, array(
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
     * @param [] $postData array of json data
     * @param string $url url
     * @param string $token token string
     *
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token)
    {

        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
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

    public function SendWithLine()
    {
        try {
            date_default_timezone_set("Asia/Tehran");

            if (!$this->LineNumber)
                throw new CException('شماره خط ارسال پیامک مشخص نشده است.');
            if (count($this->_numbers) < 1)
                throw new CException('شماره موبایلی وارد نشده است.');
            if (!$this->_messages || empty($this->_messages))
                throw new CException('متن پیامک وارد نشده است.');

            return $this->sendMessage();
        } catch (Exception $e) {
            throw new CException('ارسال پیامک با مشکل مواجه است.');
        }
    }

    public function getNumbers()
    {
        return $this->ValidateNumbers()->_numbers;
    }

    public function getInvalidNumbers()
    {
        return $this->ValidateNumbers()->_invalid_numbers;
    }

    public function getMessages()
    {
        return is_array($this->_messages) ? $this->_messages : array($this->_messages);
    }

    /**
     * @param $number
     * @return $this
     */
    public function AddNumber($number)
    {
        $numberVal = $number;
        if ($numberVal && $this->ValidateNumber($numberVal))
            $this->_numbers[] = $numberVal;
        else
            $this->_invalid_numbers[] = $number;
        return $this;
    }

    /**
     * @param $numbers
     * @return $this
     * @throws CException
     */
    public function AddNumbers($numbers)
    {
        if ($numbers && is_array($numbers))
            foreach ($numbers as $number)
                $this->AddNumber($number);
        else
            throw new CException('پارامتر تابع AddNumbers باید یک آرایه باشد.');
        return $this;
    }

    /**
     * Validate Mobile Number
     * @param $number
     * @return bool|int
     */
    public function ValidateNumber($number)
    {
        if (array_search($number, $this->_numbers) === false)
            return preg_match('/^[09]+[0-9]{9}+$/', $number);
        return false;
    }

    /**
     * Validates Mobile Numbers array
     * @return $this
     */
    public function ValidateNumbers()
    {
        foreach ($this->_numbers as $number)
            $this->ValidateNumber($number);
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function AddMessage($message)
    {
        $this->_messages[] = $message . ($this->messagePostfix ? "
$this->messagePostfix" : '');
        return $this;
    }

    /**
     * @param $messages
     * @return $this
     * @throws CException
     */
    public function AddMessages($messages)
    {
        if ($messages && is_array($messages))
            foreach ($messages as $message)
                $this->AddMessage($message);
        else
            throw new CException('پارامتر تابع AddMessages باید یک آرایه باشد.');
        return $this;
    }

    /**
     * Gets API Message Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageSendUrl()
    {
        return "api/MessageSend";
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
}