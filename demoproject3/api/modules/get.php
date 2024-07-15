<?php
require_once "global.php";

class Get extends GlobalMethods {

    public function fetchWeather($city, $days = 1) {
        $apiKeyAndUrl = $this->getApiKeyAndUrl();
        $apiKey = $apiKeyAndUrl['apiKey'];
        $apiUrl = $apiKeyAndUrl['apiUrl'];
        
        $url = "{$apiUrl}?key={$apiKey}&q={$city}&days={$days}";
        
        error_log("Fetching weather data from URL: $url");
        
        $response = @file_get_contents($url);
        
        if ($response === false) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch weather data from the API.'
            ];
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($decodedResponse === null) {
            return [
                'status' => 'error',
                'message' => 'Failed to decode weather data from the API.'
            ];
        }
        
        return $decodedResponse;
    }    

    public function searchWeatherByCoords($latitude, $longitude) {
        $apiKeyAndUrl = $this->getApiKeyAndUrl();
        $apiKey = $apiKeyAndUrl['apiKey'];
        $apiUrl = $apiKeyAndUrl['apiUrl'];
        
        $url = "{$apiUrl}?key={$apiKey}&q={$latitude},{$longitude}";
        
        error_log("Fetching weather data from URL: $url");
        
        $response = @file_get_contents($url);
        
        if ($response === false) {
          return [
            'status' => 'error',
            'message' => 'Failed to fetch weather data from the API.'
          ];
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($decodedResponse === null) {
          return [
            'status' => 'error',
            'message' => 'Failed to decode weather data from the API.'
          ];
        }
        
        return $decodedResponse;
      }

    public function getApiKeyAndUrl() {
        return [
            'apiKey' => '19810555296f4c97b0b131943241307',
            'apiUrl' => 'http://api.weatherapi.com/v1/forecast.json'
        ];
    }
}

?>
