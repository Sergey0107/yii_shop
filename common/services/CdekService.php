<?php

namespace common\services;
use AntistressStore\CdekSDK2\CdekClientV2;
use AntistressStore\CdekSDK2\Entity\Requests\DeliveryPoints;
use AntistressStore\CdekSDK2\Entity\Requests\Tariff;
use backend\models\City;
use Yii;

class CdekService
{
    private $client;
    public $isTestMode;

    public function __construct(bool $isTestMode = false)
    {
        $this->isTestMode = false;
        $this->client = new CdekClientV2('TEST');
    }

    public function getPickupPoints(int $cityCode): array
    {

        if ($this->isTestMode) {
            return $this->getTestPoints(55.7558, 37.6173);
        }

        try {
            $request = (new DeliveryPoints())
                ->setType('PVZ')
                ->setCityCode($cityCode);

            $response = $this->client->getDeliveryPoints($request);
            return $this->formatPoints($response);
        } catch (\Exception $e) {
            Yii::error('CDEK API error: ' . $e->getMessage(), __METHOD__);
            return $this->getTestPoints(55.7558, 37.6173);
        }
    }

    private function formatPoints(iterable $response): array
    {
        $points = [];
        foreach ($response as $item) {
            $points[] = [
                'id' => $item->getCode(),
                'name' => $item->getName(),
                'address' => $item->getLocation()->getAddress(),
                'hours' => $item->getWorkTime() ?? 'пн-пт 9:00-18:00',
                'lat' => $item->getLocation()->getLatitude(),
                'lng' => $item->getLocation()->getLongitude(),
            ];
        }
        return $points;
    }

    private function getTestPoints(float $lat, float $lng): array
    {
        return [
            [
                'id' => 'PVZ1',
                'name' => 'SDEK Тестовый пункт №1',
                'address' => 'ул. Тестовая, д. 1, Кострома',
                'hours' => 'пн-пт 8:00-20:00, сб 9:00-18:00',
                'lat' => $lat + 0.01,
                'lng' => $lng + 0.01,
            ],
            [
                'id' => 'PVZ2',
                'name' => 'SDEK Тестовый пункт №2',
                'address' => 'ул. Примерная, д. 5, Кострома',
                'hours' => 'пн-пт 9:00-18:00',
                'lat' => $lat - 0.01,
                'lng' => $lng + 0.005,
            ],
        ];
    }

    public function getTariffSumm ($weight, $destination = null)
    {
        $tariff = (new Tariff())
            ->setTariffCode(138)
            ->setCityCodes(City::CODE_KOSTROMA_CDEK, $destination ?? City::CODE_KOSTROMA_CDEK)
            ->setPackageWeight($weight)
            ->addServices(['PART_DELIV'])
        ;

        $tariff_response = $this->client->calculateTariff($tariff);
        return $tariff_response->getDeliverySum();
    }
}