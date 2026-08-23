<?php

use App\Models\UsuarioModel;
use App\Services\AuthService;
use CodeIgniter\Test\CIUnitTestCase;

final class AuthServiceTest extends CIUnitTestCase
{
    public function testAuthenticatesModernPassword(): void
    {
        $model = $this->createMock(UsuarioModel::class);
        $model->expects($this->once())
            ->method('findByEmail')
            ->with('admin@example.com')
            ->willReturn(['id' => 1, 'email' => 'admin@example.com', 'senha' => password_hash('secret', PASSWORD_DEFAULT)]);
        $model->expects($this->never())->method('update');

        $usuario = (new AuthService($model))->authenticate('admin@example.com', 'secret');

        $this->assertSame(1, $usuario['id']);
    }

    public function testRejectsInvalidPassword(): void
    {
        $model = $this->createMock(UsuarioModel::class);
        $model->method('findByEmail')->willReturn([
            'id' => 1,
            'email' => 'admin@example.com',
            'senha' => password_hash('correct', PASSWORD_DEFAULT),
        ]);

        $this->assertNull((new AuthService($model))->authenticate('admin@example.com', 'wrong'));
    }

    public function testMigratesLegacyMd5AfterSuccessfulLogin(): void
    {
        $model = $this->createMock(UsuarioModel::class);
        $model->method('findByEmail')->willReturn([
            'id' => 7,
            'email' => 'legacy@example.com',
            'senha' => md5('legacy-password'),
        ]);
        $model->expects($this->once())
            ->method('update')
            ->with(7, $this->callback(static function (array $data): bool {
                return password_verify('legacy-password', $data['senha']);
            }))
            ->willReturn(true);

        $usuario = (new AuthService($model))->authenticate('legacy@example.com', 'legacy-password');

        $this->assertSame(7, $usuario['id']);
        $this->assertFalse(preg_match('/^[a-f0-9]{32}$/i', $usuario['senha']) === 1);
    }
}
