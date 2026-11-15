<?php

namespace App\Database\Seeds;

use App\Models\InstrutorLocalModel;
use App\Models\InstrutorModel;
use CodeIgniter\Database\Seeder;

class DemoAulasSeeder extends Seeder
{
    public function run()
    {
        $pessoas = [
            ['Demo Arara', 'Ana Souza', 'Graduado(a)', 'Avenida Paulista, 1578, Bela Vista, São Paulo - SP', -23.561414, -46.655881],
            ['Demo Berimbau', 'Bruno Lima', 'Instrutor(a)', 'Rua Vergueiro, 1000, Liberdade, São Paulo - SP', -23.570116, -46.640305],
            ['Demo Candeia', 'Camila Rocha', 'Mestrando(a)', 'Parque Ibirapuera, São Paulo - SP', -23.587416, -46.657634],
            ['Demo Dendê', 'Diego Alves', 'Mestre', 'Praça da Sé, Sé, São Paulo - SP', -23.550520, -46.633309],
            ['Demo Estrela', 'Elisa Martins', 'Graduado(a)', 'Rua Augusta, 1500, Consolação, São Paulo - SP', -23.556068, -46.657133],
            ['Demo Falcão', 'Felipe Santos', 'Instrutor(a)', 'Avenida Brigadeiro Faria Lima, 2232, Pinheiros, São Paulo - SP', -23.584173, -46.683992],
            ['Demo Ginga', 'Gabriela Nunes', 'Mestrando(a)', 'Largo da Batata, Pinheiros, São Paulo - SP', -23.566981, -46.701256],
            ['Demo Horizonte', 'Henrique Costa', 'Mestre', 'Avenida Cruzeiro do Sul, 1800, Santana, São Paulo - SP', -23.516803, -46.625544],
            ['Demo Iara', 'Isabela Freitas', 'Graduado(a)', 'Rua Harmonia, 797, Vila Madalena, São Paulo - SP', -23.554343, -46.692327],
            ['Demo Jatobá', 'João Pereira', 'Instrutor(a)', 'Avenida Paes de Barros, 2400, Mooca, São Paulo - SP', -23.559750, -46.594193],
            ['Demo Kiwi', 'Karen Oliveira', 'Mestrando(a)', 'Avenida São João, 439, República, São Paulo - SP', -23.544827, -46.642751],
            ['Demo Lua', 'Lucas Ferreira', 'Mestre', 'Rua da Consolação, 2303, Cerqueira César, São Paulo - SP', -23.557462, -46.661260],
            ['Demo Mandinga', 'Mariana Dias', 'Graduado(a)', 'Avenida Domingos de Morais, 2564, Vila Mariana, São Paulo - SP', -23.595601, -46.637455],
            ['Demo Ninho', 'Nicolas Barros', 'Instrutor(a)', 'Rua Três Rios, 252, Bom Retiro, São Paulo - SP', -23.530810, -46.642352],
            ['Demo Onça', 'Olivia Ramos', 'Mestrando(a)', 'Avenida Celso Garcia, 2230, Brás, São Paulo - SP', -23.540028, -46.609772],
        ];

        $instrutores = new InstrutorModel();
        $locais = new InstrutorLocalModel();
        foreach ($pessoas as [$apelido, $nome, $graduacao, $endereco, $latitude, $longitude]) {
            if ($instrutores->where('apelido', $apelido)->first() !== null) {
                continue;
            }
            $instrutores->insert([
                'nome' => $nome,
                'apelido' => $apelido,
                'graduacao' => $graduacao,
                'biografia' => 'Perfil de demonstração para validar a página de aulas, os locais e o mapa.',
            ]);
            $id = (int) $instrutores->getInsertID();
            $locais->insert([
                'instrutor_id' => $id,
                'nome' => 'Local de aula — ' . $apelido,
                'endereco' => $endereco,
                'dias_horarios' => 'Terças e quintas, 19h',
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }
    }
}
