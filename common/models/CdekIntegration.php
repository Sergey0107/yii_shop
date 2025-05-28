<?php
namespace app\components;

use GuzzleHttp\Client;
use yii\base\Component;

class CdekClient extends Component
{
    public $account;
    public $securePassword;
    public $apiUrl = 'https://api.cdek.ru/v2/';

    private $authToken;
    private $httpClient;

    public function init()
    {
        parent::init();
        $this->httpClient = new Client(['baseUrl' => $this->apiUrl]);
    }

    // Аутентификация в API СДЭК (получение токена)
    public function authenticate()
    {
        $response = $this->httpClient->post('oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->account,
            'client_secret' => $this->securePassword,
        ])->send();

        if ($response->isOk) {
            $this->authToken = $response->data['access_token'];
            return true;
        }

        return false;
    }

    // Пример метода для расчета доставки
    public function calculateDelivery($fromLocation, $toLocation, $weight, $size)
    {
        if (!$this->authToken) {
            $this->authenticate();
        }

        $response = $this->httpClient->post('calculator/tariff', [
            'from_location' => $fromLocation,
            'to_location' => $toLocation,
            'weight' => $weight,
            'size' => $size,
        ], [
            'Authorization' => 'Bearer ' . $this->authToken,
        ])->send();

        return $response->data;
    }
}