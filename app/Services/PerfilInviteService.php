<?php

namespace App\Services;

class PerfilInviteService
{
    public function send(string $email, string $name, string $token): bool
    {
        $settings = (new ThemeService())->settings();
        if ($settings['smtp_host'] === '' || $settings['smtp_from_email'] === '') {
            return false;
        }

        try {
            $mail = \Config\Services::email([
            'protocol' => 'smtp',
            'SMTPHost' => $settings['smtp_host'],
            'SMTPUser' => $settings['smtp_user'],
            'SMTPPass' => $settings['smtp_password'],
            'SMTPPort' => (int) $settings['smtp_port'],
            'SMTPCrypto' => $settings['smtp_crypto'] === 'none' ? '' : $settings['smtp_crypto'],
            'mailType' => 'html',
            'charset' => 'UTF-8',
            ], false);
            $link = base_url('meu-perfil/ativar/' . $token);
            $mail->setFrom($settings['smtp_from_email'], $settings['smtp_from_name'] ?: $settings['site_name']);
            $mail->setTo($email);
            $mail->setSubject('Defina sua senha para atualizar seu perfil');
            $mail->setMessage('<p>Olá, ' . esc($name) . '.</p><p>Use o link abaixo para definir sua senha e atualizar seu perfil:</p><p><a href="' . esc($link, 'attr') . '">Definir minha senha</a></p><p>Este link vale por 24 horas.</p>');
            return $mail->send();
        } catch (\Throwable $exception) {
            log_message('warning', 'Não foi possível enviar convite de perfil: {message}', ['message' => $exception->getMessage()]);
            return false;
        }
    }
}
