<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\GeocodingService;
use App\Models\InstrutorLocalModel;
use App\Models\InstrutorModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Instrutor extends BaseController
{
    private const GRADUACOES = ['Graduado(a)', 'Instrutor(a)', 'Mestrando(a)', 'Mestre'];

    private InstrutorModel $instrutores;
    private InstrutorLocalModel $locais;
    private GeocodingService $geocoding;

    public function __construct(?GeocodingService $geocoding = null)
    {
        $this->instrutores = new InstrutorModel();
        $this->locais = new InstrutorLocalModel();
        $this->geocoding = $geocoding ?? new GeocodingService();
    }

    public function index()
    {
        return view('admin/instrutor_index', [
            'instrutores' => $this->instrutores->orderBy('apelido')->paginate($this->perPage()),
            'pager' => $this->instrutores->pager,
        ]);
    }

    public function novo()
    {
        return view('admin/instrutor_novo', ['graduacoes' => self::GRADUACOES]);
    }

    public function editar($id)
    {
        $instrutor = $this->instrutores->find((int) $id);
        if ($instrutor === null) {
            throw PageNotFoundException::forPageNotFound('Cadastro não encontrado.');
        }

        return view('admin/instrutor_editar', [
            'instrutor' => $instrutor,
            'locais' => $this->locais->where('instrutor_id', $instrutor['id'])->findAll(),
            'graduacoes' => self::GRADUACOES,
        ]);
    }

    public function salvar($id = null)
    {
        $graduacao = trim((string) $this->request->getPost('graduacao'));
        $dados = [
            'nome' => trim((string) $this->request->getPost('nome')),
            'apelido' => trim((string) $this->request->getPost('apelido')),
            'graduacao' => $graduacao,
            'biografia' => trim((string) $this->request->getPost('biografia')),
        ];
        if ($dados['nome'] === '' || $dados['apelido'] === '' || !in_array($graduacao, self::GRADUACOES, true)) {
            return redirect()->back()->withInput()->with('errors', ['Informe o nome, apelido e uma graduação válida.']);
        }

        $existing = $id === null ? null : $this->instrutores->find((int) $id);
        if ($id !== null && $existing === null) {
            throw PageNotFoundException::forPageNotFound('Cadastro não encontrado.');
        }

        $profile = $this->request->getFile('foto_perfil');
        if ($profile !== null && $profile->getName() !== '') {
            if (!$this->validateImage('foto_perfil')) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $dados['foto_perfil'] = $this->moveImage($profile);
        }

        $gallery = $this->request->getFiles()['fotos'] ?? [];
        $newPhotos = [];
        foreach ($gallery as $photo) {
            if ($photo->getName() === '') {
                continue;
            }
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!$photo->isValid() || !in_array($photo->getMimeType(), $allowedMimes, true) || $photo->getSizeByUnit('kb') > 5120) {
                return redirect()->back()->withInput()->with('errors', ['Cada foto deve ser uma imagem válida de até 5 MB.']);
            }
            $newPhotos[] = $this->moveImage($photo);
        }
        if ($newPhotos !== []) {
            $oldPhotos = json_decode((string) ($existing['fotos'] ?? '[]'), true) ?: [];
            $dados['fotos'] = json_encode(array_values(array_merge($oldPhotos, $newPhotos)));
        }

        $db = db_connect();
        $db->transStart();
        if ($id !== null) {
            $dados['id'] = (int) $id;
        }
        $this->instrutores->save($dados);
        $instrutorId = $id === null ? (int) $this->instrutores->getInsertID() : (int) $id;
        $this->locais->where('instrutor_id', $instrutorId)->delete();
        $locationsNotFound = $this->saveLocais($instrutorId);
        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('errors', ['Não foi possível salvar o cadastro.']);
        }
        $message = $locationsNotFound
            ? 'Cadastro salvo, mas um ou mais endereços não foram localizados automaticamente.'
            : 'Cadastro salvo com sucesso.';
        return redirect()->to('/admin/instrutor')->with('success', $message);
    }

    public function excluir($id)
    {
        if ($this->instrutores->delete((int) $id)) {
            return redirect()->to('/admin/instrutor')->with('success', 'Cadastro excluído com sucesso.');
        }
        return redirect()->back()->with('errors', ['Não foi possível excluir o cadastro.']);
    }

    private function saveLocais(int $instrutorId): bool
    {
        $names = (array) $this->request->getPost('local_nome');
        $addresses = (array) $this->request->getPost('local_endereco');
        $schedules = (array) $this->request->getPost('local_dias_horarios');
        $latitudes = (array) $this->request->getPost('local_latitude');
        $longitudes = (array) $this->request->getPost('local_longitude');
        $locationsNotFound = false;
        foreach ($names as $index => $name) {
            $name = trim((string) $name);
            $address = trim((string) ($addresses[$index] ?? ''));
            if ($name === '' && $address === '') continue;
            $name = $name !== '' ? $name : $address;
            $coordinates = $this->geocoding->coordinatesFor($address);
            if ($address !== '' && $coordinates === null) {
                $locationsNotFound = true;
            }
            $this->locais->insert([
                'instrutor_id' => $instrutorId, 'nome' => $name,
                'endereco' => $address ?: null,
                'dias_horarios' => trim((string) ($schedules[$index] ?? '')) ?: null,
                'latitude' => $coordinates['latitude'] ?? (is_numeric($latitudes[$index] ?? null) ? $latitudes[$index] : null),
                'longitude' => $coordinates['longitude'] ?? (is_numeric($longitudes[$index] ?? null) ? $longitudes[$index] : null),
            ]);
        }
        return $locationsNotFound;
    }

    private function validateImage(string $field): bool
    {
        return $this->validate([$field => ['rules' => "uploaded[$field]|max_size[$field,5120]|is_image[$field]"]]);
    }

    private function moveImage($file): string
    {
        $name = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $name);
        return $name;
    }
}
