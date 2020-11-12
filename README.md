<h1 align="center"> weather </h1>

<p align="center"> 基于  高德开放平台 的 PHP 天气信息组件。</p>


<h2 align="center"> 安装 </h2>

```shell
$ composer require LostControls/weather -vvv
```

<h2 align="center"> 配置 </h2>
在使用本扩展之前，你需要去 高德开放平台 注册账号，然后创建应用，获取应用的 API Key。

<h2 align="center"> 使用 </h2>

```
use LostControls\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);

```

<h4 align="center"> 获取实时天气 </h4>

`
$response = $weather->getWeather('长沙');
`

**示例**

```
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
                    "province": "湖南",
                    "city": "长沙县",
                    "adcode": "430121",
                    "weather": "晴",
                    "temperature": "24",
                    "winddirection": "东北",
                    "windpower": "≤3",
                    "humidity": "36",
                    "reporttime": "2020-11-11 16:26:23"
         }
    ]
}
```

<h4 align="center"> 获取近期天气预报 </h4>

```
{
    "status": "1",
    "count": "2",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "长沙市",
            "adcode": "430100",
            "province": "湖南",
            "reporttime": "2020-11-11 16:26:22",
            "casts": [
                {
                    "date": "2020-11-11",
                    "week": "3",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "24",
                    "nighttemp": "9",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-11-12",
                    "week": "4",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "24",
                    "nighttemp": "11",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-11-13",
                    "week": "5",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "24",
                    "nighttemp": "11",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-11-14",
                    "week": "6",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "23",
                    "nighttemp": "12",
                    "daywind": "北",
                    "nightwind": "北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                }
            ]
        },
    ]
}
```

<h4 align="center"> 获取 XML 格式返回值 </h4>

**第三个参数为返回值类型，可选 json 与 xml，默认 json：**

`
$response = $weather->getWeather('深圳', 'all', 'xml');
`

示例：

```
<response>
    <status>1</status>
    <count>1</count>
    <info>OK</info>
    <infocode>10000</infocode>
    <lives type="list">
        <live>
            <province>广东</province>
            <city>深圳市</city>
            <adcode>440300</adcode>
            <weather>中雨</weather>
            <temperature>27</temperature>
            <winddirection>西南</winddirection>
            <windpower>5</windpower>
            <humidity>94</humidity>
            <reporttime>2018-08-21 16:00:00</reporttime>
        </live>
    </lives>
</response>
```

<h4 align="center"> 参数说明 </h4>

`
array|string getWeather(string $city, string $type = 'base', string $format = 'json')
`

+ $city - 城市名，比如：“长沙”；
+ $type - 返回内容类型：base: 返回实况天气 / all: 返回预报天气；
+ $format  - 输出的数据格式，默认为 json 格式，当 output 设置为 “xml” 时，输出的为 XML 格式的数据。

<h4 align="center"> 在 Laravel 中使用 </h4>

在 Laravel 中使用也是同样的安装方式，配置写在 config/services.php 中：

```
    .
    .
    .
     'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ],
```

然后在 .env 中配置 WEATHER_API_KEY ：

`
WEATHER_API_KEY=xxxxxxxxxxxxxxxxxxxxx
`

可以用两种方式来获取 Overtrue\Weather\Weather 实例：

<h4 align="center"> 方法参数注入 </h4>

```
    .
    .
    .
    public function edit(Weather $weather) 
    {
        $response = $weather->getWeather('深圳');
    }
    .
    .
    .
```

<h4 align="center"> 服务名访问 </h4>

```
    .
    .
    .
    public function edit() 
    {
        $response = app('weather')->getWeather('深圳');
    }
    .
    .
    .
```

<h4 align="center"> 参考 </h4>

+ [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)


## License

MIT