<?php
namespace LostControls\Weather;

use GuzzleHttp\Client;
use LostControls\Weather\Exceptions\HttpException;
use LostControls\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    // API key
    protected $key = '0db9f09c7a53e5ac7173425936764ce4';
    protected $guzzleOptions = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * Created by PhpStorm.
     * User: ChenYiWen
     * DateTime: 2020/11/10 17:28
     * @param $city
     * @param string|string $type
     * @param string|string $format
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWeather($city, $type = 'live', $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        $type = [
            'live' => 'base',
            'forecast' => 'all',
        ];

        // 1.对 $format 和 $type 参数进行检查，不在范围内的抛出异常
        if (!\in_array(\strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!\in_array(\strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        // 2. 封装 query 参数，并对空值进行过滤
        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => $format,
            'extensions' =>  $type,
        ]);

        try {
            // 3. 调用 getHttpClient 获取实例，并调用该实例的 get 方法，
            // 传递参数为两个：$url、['query' => $query],
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            // 4. 返回值根据 $format 返回不同的格式
            // 当 $format 为 json 时，返回数组格式，否则为xml
            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            // 5. 当调用出现异常时捕获并抛出，消息为捕获到的异常消息，
            // 并将调用异常作为 $previousException 传入。
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    public function getForecastWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }
}