<?php

namespace App\Http\Controllers\Proxy;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    /**
     * @var string
     */
    private $apiKey = "5c0a95bee3-3ddfe8ecd0-94ab4a52b9";

    public function index()
    {
        $client = new Client();
        $response = $client->get(sprintf("https://proxy6.net/api/%s/getproxy", $this->apiKey));

        return $response->getBody()->getContents();
    }
}
