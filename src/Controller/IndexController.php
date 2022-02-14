<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function getWeather(HttpClientInterface $weatherClient): Response
    {
        $apiKey = $this->getParameter('openweathermap_token');
        $response = $weatherClient->request('GET', '/data/2.5/weather', [
            'query' => [
                'id' => $this->getParameter('city_id'),
                'lang' => 'en',
                'units' => 'metric',
                'appid' => $apiKey
            ]
        ]);

        $currentTime = date('m/d/Y h:i:s a', time());
        $data = $response->toArray();

        $temp = array($data["main"]["temp"]);
        $feels = array($data["main"]["feels_like"]);
        $pressure = array($data["main"]["pressure"]);
        $wind = array($data["wind"]["speed"]);
        $clouds = array($data["weather"]["0"]["description"]);
        $result = "Температура в Минске " . implode($temp) . "\n". "Ощущается как " . implode($feels) . "\n" . "Скорость ветра " . implode($wind) . "\n". "Атмосферное давление " . implode($pressure) . "\n" . "Облачность " . implode($clouds) . "\n" . "Время в Минске " . $currentTime;

        return new Response($result);
    }
}
