<?php
namespace Shayanadc\PayamResan;
class PayamResan {
    protected $client;
    protected $parameters;

    public function __construct() {
        $this->client = new \SoapClient('http://sms-webservice.ir/v1/v1.asmx?WSDL', array('cache_wsdl' => 'WSDL_CACHE_MEMORY'));

        $this->parameters['Username'] = 'ag';
        $this->parameters['PassWord'] = 'agsa';
        $this->parameters['SenderNumber'] = 'aga';
    }

    public function validateParams($mobile, $message) {
        if(!is_array($mobile) || !is_string($message)){
            throw new \InvalidArgumentException('mobile is should be array and message should be string');
        }
    foreach($mobile as $m){
            $pattern = '/^0?9\d{9}$/';
            if(!preg_match_all($pattern, $m)){
                throw new \InvalidArgumentException('mobile number is not valid');
            }
        }
    }
    public function sendMessage($mobile, $message) {
        $this->validateParams($mobile,$message);
        $this->parameters['RecipientNumbers'] = $mobile;
        $this->parameters['MessageBodie'] = $message;
        $this->parameters['Type'] = 1;
        $this->parameters['AllowedDelay'] = 0;

        $result = $this->client->SendMessage($this->parameters)->SendMessageResult->long;

        if($result <= 0){
            throw new \Exception('PayamResan Fail To Sending SMS For Error: ' , compact('result'));
        }
        return true;
    }
    public function getMessagesStatus($messageId) {
        $this->parameters['messagesId'] = $messageId;
        $res = $this->client->GetMessagesStatus($this->parameters);
        return $res;
    }
}
