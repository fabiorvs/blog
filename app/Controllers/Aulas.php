<?php

namespace App\Controllers;

use App\Models\InstrutorLocalModel;
use App\Models\InstrutorModel;
use App\Services\GeocodingService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Aulas extends BaseController
{
    private GeocodingService $geocoding;

    public function __construct(?GeocodingService $geocoding = null)
    {
        $this->geocoding = $geocoding ?? new GeocodingService();
    }

    public function index()
    {
        $instrutores = (new InstrutorModel())->orderBy('apelido')->findAll();
        $locais = (new InstrutorLocalModel())->orderBy('nome')->findAll();
        $cep = preg_replace('/\D/', '', (string) $this->request->getGet('cep'));
        $origin = null;
        $searchError = null;
        if ($cep !== '') {
            if (strlen($cep) !== 8) {
                $searchError = 'Informe um CEP com 8 dígitos.';
            } else {
                $coordinates = $this->geocoding->coordinatesForCep($cep);
                if ($coordinates === null) {
                    $searchError = 'Não foi possível localizar esse CEP.';
                } else {
                    $origin = ['latitude' => (float) $coordinates['latitude'], 'longitude' => (float) $coordinates['longitude']];
                }
            }
        }
        $locaisPorInstrutor = [];
        $distancias = [];
        foreach ($locais as $local) {
            if ($origin !== null && $local['latitude'] !== null && $local['longitude'] !== null) {
                $local['distancia'] = $this->distanceInKm($origin['latitude'], $origin['longitude'], (float) $local['latitude'], (float) $local['longitude']);
                $distancias[$local['instrutor_id']] = min($distancias[$local['instrutor_id']] ?? INF, $local['distancia']);
            }
            $locaisPorInstrutor[$local['instrutor_id']][] = $local;
        }

        if ($origin !== null) {
            usort($instrutores, static fn (array $a, array $b): int => ($distancias[$a['id']] ?? INF) <=> ($distancias[$b['id']] ?? INF));
        }

        return view('aulas', [
            'instrutores' => $instrutores,
            'locaisPorInstrutor' => $locaisPorInstrutor,
            'mapLocais' => array_values(array_filter($locais, static fn (array $local): bool => $local['latitude'] !== null && $local['longitude'] !== null)),
            'cep' => $cep,
            'origin' => $origin,
            'searchError' => $searchError,
        ]);
    }

    public function perfil($id)
    {
        $instrutor = (new InstrutorModel())->find((int) $id);
        if ($instrutor === null) {
            throw PageNotFoundException::forPageNotFound('Cadastro não encontrado.');
        }

        $locais = (new InstrutorLocalModel())->where('instrutor_id', $instrutor['id'])->orderBy('nome')->findAll();
        $instrutor['fotos'] = json_decode((string) ($instrutor['fotos'] ?? '[]'), true) ?: [];

        return view('aula_perfil', [
            'instrutor' => $instrutor,
            'locais' => $locais,
            'mapLocais' => array_values(array_filter($locais, static fn (array $local): bool => $local['latitude'] !== null && $local['longitude'] !== null)),
        ]);
    }

    private function distanceInKm(float $latitudeA, float $longitudeA, float $latitudeB, float $longitudeB): float
    {
        $earthRadius = 6371.0;
        $latitudeDelta = deg2rad($latitudeB - $latitudeA);
        $longitudeDelta = deg2rad($longitudeB - $longitudeA);
        $a = sin($latitudeDelta / 2) ** 2 + cos(deg2rad($latitudeA)) * cos(deg2rad($latitudeB)) * sin($longitudeDelta / 2) ** 2;
        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 1);
    }
}
