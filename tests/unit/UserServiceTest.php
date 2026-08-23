<?php

use App\Models\UsuarioModel;
use App\Services\UserService;
use CodeIgniter\Test\CIUnitTestCase;

final class UserServiceTest extends CIUnitTestCase
{
    public function testCreatesUserWithPasswordHash(): void
    {
        $model = $this->createMock(UsuarioModel::class);
        $model->method('emailExists')->with('novo@example.com', null)->willReturn(false);
        $model->expects($this->once())->method('save')->with($this->callback(static function (array $data): bool {
            return $data['nome'] === 'Novo Usuário'
                && $data['email'] === 'novo@example.com'
                && password_verify('senha-segura', $data['senha']);
        }))->willReturn(true);

        $result = (new UserService($model))->save([
            'nome' => ' Novo Usuário ',
            'email' => 'NOVO@example.com',
            'senha' => 'senha-segura',
            'confirmacao_senha' => 'senha-segura',
        ]);

        $this->assertTrue($result['success']);
        $this->assertSame([], $result['errors']);
    }

    public function testRejectsDuplicateEmailAndInvalidPassword(): void
    {
        $model = $this->createMock(UsuarioModel::class);
        $model->method('emailExists')->willReturn(true);
        $model->expects($this->never())->method('save');

        $result = (new UserService($model))->save([
            'nome' => 'Usuário',
            'email' => 'existente@example.com',
            'senha' => '123',
            'confirmacao_senha' => '456',
        ]);

        $this->assertFalse($result['success']);
        $this->assertCount(3, $result['errors']);
    }
}
