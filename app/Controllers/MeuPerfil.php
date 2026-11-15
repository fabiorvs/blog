<?php

namespace App\Controllers;

use App\Models\InstrutorLocalModel;
use App\Models\InstrutorModel;
use App\Services\GeocodingService;

class MeuPerfil extends BaseController
{
    private const GRADUACOES = ['Graduado(a)', 'Instrutor(a)', 'Mestrando(a)', 'Mestre'];

    public function login()
    {
        if (session('perfil_id')) return redirect()->to('/meu-perfil');
        return view('perfil/login');
    }

    public function autenticar()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $perfil = (new InstrutorModel())->where('email', $email)->first();
        if ($perfil === null || empty($perfil['senha_hash']) || !password_verify((string) $this->request->getPost('senha'), $perfil['senha_hash'])) {
            return redirect()->back()->withInput()->with('error', 'E-mail ou senha inválidos.');
        }
        $this->startSession($perfil);
        return redirect()->to('/meu-perfil');
    }

    public function ativar(string $token)
    {
        $perfil = (new InstrutorModel())->where('convite_token', hash('sha256', $token))->first();
        if ($perfil === null || empty($perfil['convite_expira_em']) || strtotime($perfil['convite_expira_em']) < time()) {
            return view('perfil/mensagem', ['message' => 'Este link é inválido ou expirou. Solicite um novo convite ao responsável pelo site.']);
        }
        return view('perfil/ativar', ['token' => $token, 'perfil' => $perfil]);
    }

    public function concluirAtivacao(string $token)
    {
        $model = new InstrutorModel();
        $perfil = $model->where('convite_token', hash('sha256', $token))->first();
        $senha = (string) $this->request->getPost('senha');
        if ($perfil === null || empty($perfil['convite_expira_em']) || strtotime($perfil['convite_expira_em']) < time()) {
            return redirect()->to('/meu-perfil/login')->with('error', 'O convite expirou.');
        }
        if (strlen($senha) < 8 || $senha !== (string) $this->request->getPost('confirmacao_senha')) {
            return redirect()->back()->withInput()->with('error', 'Use uma senha de ao menos 8 caracteres e confirme-a corretamente.');
        }
        $model->update($perfil['id'], ['senha_hash' => password_hash($senha, PASSWORD_DEFAULT), 'convite_token' => null, 'convite_expira_em' => null]);
        $this->startSession($perfil);
        return redirect()->to('/meu-perfil')->with('success', 'Senha criada. Agora você pode atualizar seu perfil.');
    }

    public function index()
    {
        $perfil = $this->current();
        if ($perfil === null) return redirect()->to('/meu-perfil/login');
        return view('perfil/index', ['instrutor' => $perfil, 'locais' => (new InstrutorLocalModel())->where('instrutor_id', $perfil['id'])->findAll(), 'graduacoes' => self::GRADUACOES]);
    }

    public function salvar()
    {
        $perfil = $this->current();
        if ($perfil === null) return redirect()->to('/meu-perfil/login');
        $graduacao = trim((string) $this->request->getPost('graduacao'));
        $dados = ['nome' => trim((string) $this->request->getPost('nome')), 'apelido' => trim((string) $this->request->getPost('apelido')), 'graduacao' => $graduacao, 'whatsapp' => trim((string) $this->request->getPost('whatsapp')), 'biografia' => trim((string) $this->request->getPost('biografia'))];
        if ($dados['nome'] === '' || $dados['apelido'] === '' || !in_array($graduacao, self::GRADUACOES, true)) return redirect()->back()->withInput()->with('error', 'Informe nome, apelido e uma graduação válida.');
        try {
            $profilePhoto = $this->request->getFile('foto_perfil');
            if ($profilePhoto !== null && $profilePhoto->getName() !== '') $dados['foto_perfil'] = $this->storeImage($profilePhoto);
            $photos = json_decode((string) ($perfil['fotos'] ?? '[]'), true) ?: [];
            foreach ($this->request->getFiles()['fotos'] ?? [] as $photo) {
                if ($photo->getName() !== '') $photos[] = $this->storeImage($photo);
            }
            if ($photos !== []) $dados['fotos'] = json_encode(array_values($photos));
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }
        (new InstrutorModel())->update($perfil['id'], $dados);
        $locais = new InstrutorLocalModel();
        $locais->where('instrutor_id', $perfil['id'])->delete();
        $names = (array) $this->request->getPost('local_nome'); $addresses = (array) $this->request->getPost('local_endereco'); $schedules = (array) $this->request->getPost('local_dias_horarios');
        $geocoding = new GeocodingService();
        foreach ($names as $index => $name) {
            $name = trim((string) $name); $address = trim((string) ($addresses[$index] ?? ''));
            if ($name === '' && $address === '') continue;
            $coordinates = $address === '' ? null : $geocoding->coordinatesFor($address);
            $locais->insert(['instrutor_id' => $perfil['id'], 'nome' => $name ?: $address, 'endereco' => $address ?: null, 'dias_horarios' => trim((string) ($schedules[$index] ?? '')) ?: null, 'latitude' => $coordinates['latitude'] ?? null, 'longitude' => $coordinates['longitude'] ?? null]);
        }
        return redirect()->to('/meu-perfil')->with('success', 'Perfil atualizado com sucesso.');
    }

    public function sair()
    {
        session()->remove(['perfil_id', 'perfil_nome']);
        return redirect()->to('/meu-perfil/login');
    }

    public function excluirFoto()
    {
        $perfil = $this->current();
        if ($perfil === null) return redirect()->to('/meu-perfil/login');

        $photo = basename((string) $this->request->getPost('foto'));
        $type = (string) $this->request->getPost('tipo');
        $model = new InstrutorModel();
        if ($type === 'perfil' && $photo !== '' && hash_equals((string) ($perfil['foto_perfil'] ?? ''), $photo)) {
            $model->update($perfil['id'], ['foto_perfil' => null]);
        } elseif ($type === 'galeria') {
            $photos = json_decode((string) ($perfil['fotos'] ?? '[]'), true) ?: [];
            if (!in_array($photo, $photos, true)) return redirect()->to('/meu-perfil')->with('error', 'Foto não encontrada no seu perfil.');
            $model->update($perfil['id'], ['fotos' => json_encode(array_values(array_filter($photos, static fn (string $item): bool => $item !== $photo)))]);
        } else {
            return redirect()->to('/meu-perfil')->with('error', 'Foto não encontrada no seu perfil.');
        }

        $path = FCPATH . 'uploads/' . $photo;
        if ($photo !== '' && is_file($path)) unlink($path);
        return redirect()->to('/meu-perfil')->with('success', 'Foto excluída do seu perfil.');
    }

    private function current(): ?array
    {
        $id = (int) session('perfil_id');
        return $id > 0 ? (new InstrutorModel())->find($id) : null;
    }

    private function startSession(array $perfil): void
    {
        session()->regenerate(true);
        session()->set(['perfil_id' => (int) $perfil['id'], 'perfil_nome' => $perfil['apelido']]);
    }

    private function storeImage(\CodeIgniter\HTTP\Files\UploadedFile $file): string
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!$file->isValid() || !in_array($file->getMimeType(), $allowedMimes, true) || $file->getSizeByUnit('kb') > 5120) {
            throw new \InvalidArgumentException('Envie somente imagens JPG, PNG ou WebP de até 5 MB.');
        }
        $name = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $name);
        return $name;
    }
}
