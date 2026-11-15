<?php

namespace App\Services;

use Config\Geocoding;

class GeocodingService
{
    /**
     * Localiza um CEP brasileiro, primeiro convertendo-o para endereço completo.
     * Serviços de mapas frequentemente não indexam CEPs isolados.
     */
    public function coordinatesForCep(string $cep): ?array
    {
        $cep = preg_replace('/\D/', '', $cep) ?? '';
        if (strlen($cep) !== 8) {
            return null;
        }

        $config = config(Geocoding::class);
        $key = 'geocoding-cep-' . $cep;
        $cache = cache();
        $cached = $cache->get($key);
        if (is_array($cached) && isset($cached['latitude'], $cached['longitude'])) {
            return $cached;
        }

        try {
            $client = $this->httpClient($config);
            $response = $client->get(rtrim($config->cepEndpoint, '/') . '/' . $cep . '/json/');
            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $address = json_decode($response->getBody(), true);
            if (!is_array($address) || !empty($address['erro'])) {
                return null;
            }

            $parts = array_filter([
                trim((string) ($address['logradouro'] ?? '')),
                trim((string) ($address['bairro'] ?? '')),
                trim((string) ($address['localidade'] ?? '')),
                trim((string) ($address['uf'] ?? '')),
                'Brasil',
            ]);
            $coordinates = $this->coordinatesFor(implode(', ', $parts));
            if ($coordinates !== null) {
                $cache->save($key, $coordinates, $config->cacheTtl);
            }

            return $coordinates;
        } catch (\Throwable $exception) {
            log_message('warning', 'Não foi possível consultar o CEP do local de aula: {message}', ['message' => $exception->getMessage()]);
            return null;
        }
    }

    public function coordinatesFor(string $address): ?array
    {
        $address = trim(preg_replace('/\s+/', ' ', $address) ?? '');
        if ($address === '') {
            return null;
        }

        $config = config(Geocoding::class);
        $key = 'geocoding-' . sha1(mb_strtolower($address));
        $cache = cache();
        $cached = $cache->get($key);
        if (is_array($cached) && isset($cached['latitude'], $cached['longitude'])) {
            return $cached;
        }

        try {
            $client = $this->httpClient($config);
            $response = $client->get($config->endpoint, [
                'query' => ['q' => $address, 'format' => 'jsonv2', 'limit' => 1],
            ]);
            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $result = json_decode($response->getBody(), true);
            if (!isset($result[0]['lat'], $result[0]['lon']) || !is_numeric($result[0]['lat']) || !is_numeric($result[0]['lon'])) {
                return null;
            }

            $coordinates = ['latitude' => (string) $result[0]['lat'], 'longitude' => (string) $result[0]['lon']];
            $cache->save($key, $coordinates, $config->cacheTtl);
            return $coordinates;
        } catch (\Throwable $exception) {
            log_message('warning', 'Não foi possível geocodificar o local de aula: {message}', ['message' => $exception->getMessage()]);
            return null;
        }
    }

    private function httpClient(Geocoding $config): \CodeIgniter\HTTP\CURLRequest
    {
        return \Config\Services::curlrequest([
            'timeout' => 5,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => $config->userAgent,
            ],
        ], null, null, false);
    }
}
