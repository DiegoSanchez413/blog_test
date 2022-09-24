<?php

namespace App\Http\Controllers;

use GuzzleHttp;

class APIController extends Controller
{
    public function getAPI()
    {
        $url = 'https://api.publicapis.org/entries';
        return $this->configureAPI($url);
    }

    public  function randomItem()
    {
        $url = 'https://api.publicapis.org/random';
        return $this->configureAPI($url);
    }

    public function configureAPI($url)
    {
        $client = new GuzzleHttp\Client();
        $res = $client->get($url,   [
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        return $res->getBody();
    }

    public function searchByText($text)
    {
        $url = 'https://api.publicapis.org/entries';
        $entries =  json_decode($this->configureAPI($url))->entries;
        return json_encode($this->filterByText($entries, $text));
    }

    public function filterByText($entries, $text)
    {
        $filteredEntries = [];
        foreach ($entries as $entry) {
            if (strpos($entry->API, $text) !== false) {
                array_push($filteredEntries, $entry);
            }
        }
        return $filteredEntries;
    }

    public function searchByCategory($category)
    {
        $url = 'https://api.publicapis.org/entries';
        $entries =  json_decode($this->configureAPI($url))->entries;
        return json_encode($this->filterByCategory($entries, $category));
    }

    public function filterByCategory($entries, $category)
    {
        $filteredEntries = [];
        foreach ($entries as $entry) {
            if ($entry->Category == $category) {
                array_push($filteredEntries, $entry);
            }
        }
        return $filteredEntries;
    }

    public function listCategories()
    {
        $url = 'https://api.publicapis.org/categories';
        return $this->configureAPI($url);
    }
}
