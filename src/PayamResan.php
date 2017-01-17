<?php
namespace Shayanadc\PayamResan;
class PayamResan {
    protected $client;
    protected $parameters;

    public function __construct() {
        $this->client = new \SoapClient(getenv('PAYAM_RESAN_WSDL'), array('cache_wsdl' => 'WSDL_CACHE_MEMORY'));

        $this->parameters['Username'] = getenv('PAYAM_RESAN_USERNAME');
        $this->parameters['PassWord'] = getenv('PAYAM_RESAN_PASSWORD');
        $this->parameters['SenderNumber'] = getenv('PAYAM_RESAN_NUMBER');
    }

    public function validateParams($mobile, $message) {
        if(!is_array($mobile) || !is_string($message)){
            throw new \Exception('mobile is should be array and message should be string');
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
