<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(HttpClientInterface $weatherClient): Response
    {
        $apiKey = $this->getParameter('app_index');
//        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=ru&units=metric&APPID=" . $apiKey
        $response = $weatherClient->request('GET', '/data/2.5/weather', [
            'query' => [
                'id' => 625144,
                'lang' => 'en',
                'units' => 'metric',
                'appid' => $apiKey
            ]
        ]);
        return new Response($response->getContent());
        //return $data = $data->toArray();
        //return $data = $serializer->deserialize($data, 'json');
    }
}
