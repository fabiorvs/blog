<?php

namespace App\Services;

class ThemeService
{
    public const DEFAULTS = [
        'site_name' => 'Ponto Digital',
        'site_tagline' => 'Tecnologia com contexto para decisões melhores',
        'site_description' => 'Análises práticas sobre tecnologia, negócios e produtividade para aplicar ideias e gerar resultados.',
        'logo_path' => '',
        'hero_background_path' => '',
        'hero_background_opacity' => '0.90',
        'primary_color' => '#176b4d',
        'accent_color' => '#c96a4a',
        'background_color' => '#f7f5f0',
        'text_color' => '#18201d',
        'hero_label' => 'Em destaque',
        'hero_button' => 'Ler artigo',
        'recent_title' => 'Artigos recentes',
        'show_categories' => '1',
        'show_newsletter' => '1',
        'newsletter_title' => 'Receba novos artigos no seu e-mail',
        'newsletter_text' => 'Conteúdos selecionados sobre tecnologia, negócios e produtividade.',
        'featured_post_id' => '',
        'footer_text' => 'Conteúdo feito para informar, inspirar e ajudar você a decidir melhor.',
        'analytics_scripts' => '',
    ];

    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function settings(): array
    {
        if (!$this->db->tableExists('configuracoes')) {
            return self::DEFAULTS;
        }

        $rows = $this->db->table('configuracoes')->select('chave, valor')->get()->getResultArray();
        $stored = [];
        foreach ($rows as $row) {
            $stored[$row['chave']] = (string) $row['valor'];
        }

        $settings = array_merge(self::DEFAULTS, array_intersect_key($stored, self::DEFAULTS));
        $settings['analytics_scripts'] = $this->sanitizeAnalyticsScripts($settings['analytics_scripts']);
        return $settings;
    }

    public function save(array $input): void
    {
        $settings = [];
        foreach (self::DEFAULTS as $key => $default) {
            $settings[$key] = trim((string) ($input[$key] ?? $default));
        }

        foreach (['primary_color', 'accent_color', 'background_color', 'text_color'] as $key) {
            if (preg_match('/^#[0-9a-f]{6}$/i', $settings[$key]) !== 1) {
                $settings[$key] = self::DEFAULTS[$key];
            }
        }

        $settings['show_categories'] = !empty($input['show_categories']) ? '1' : '0';
        $settings['show_newsletter'] = !empty($input['show_newsletter']) ? '1' : '0';
        $settings['featured_post_id'] = (string) max(0, (int) ($input['featured_post_id'] ?? 0));
        $settings['hero_background_opacity'] = number_format(
            min(0.98, max(0.55, (float) ($input['hero_background_opacity'] ?? self::DEFAULTS['hero_background_opacity']))),
            2,
            '.',
            ''
        );

        // Only allow external HTTPS scripts with a small, explicit attribute set.
        $settings['analytics_scripts'] = $this->sanitizeAnalyticsScripts($settings['analytics_scripts']);

        foreach (['logo_path', 'hero_background_path'] as $pathKey) {
            if ($settings[$pathKey] !== '' && preg_match('#^uploads/theme/[a-zA-Z0-9._-]+$#', $settings[$pathKey]) !== 1) {
                $settings[$pathKey] = '';
            }
        }

        $this->db->transStart();
        foreach ($settings as $key => $value) {
            $existing = $this->db->table('configuracoes')->where('chave', $key)->countAllResults();
            $data = ['valor' => $value, 'updated_at' => date('Y-m-d H:i:s')];
            if ($existing > 0) {
                $this->db->table('configuracoes')->where('chave', $key)->update($data);
            } else {
                $this->db->table('configuracoes')->insert(['chave' => $key] + $data);
            }
        }
        $this->db->transComplete();
    }

    private function sanitizeAnalyticsScripts(string $value): string
    {
        $output = [];
        if (trim($value) === '') return '';
        preg_match_all('/<script\b([^>]*)>\s*<\/script\s*>/is', $value, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $attrs = $match[1];
            if (preg_match('/\bsrc\s*=\s*["\'](https:\/\/[^"\']+)["\']/i', $attrs, $src) !== 1) continue;
            $url = $src[1];
            $parts = ['defer'];
            if (preg_match('/\basync\b/i', $attrs)) $parts[] = 'async';
            if (preg_match('/\btype\s*=\s*["\']([a-z0-9.+-]+)["\']/i', $attrs, $type)) $parts[] = 'type="' . esc($type[1], 'attr') . '"';
            $parts[] = 'src="' . esc($url, 'attr') . '"';
            preg_match_all('/\b(data-[a-z0-9_-]+)\s*=\s*["\']([^"\']*)["\']/i', $attrs, $data, PREG_SET_ORDER);
            foreach ($data as $attribute) $parts[] = strtolower($attribute[1]) . '="' . esc($attribute[2], 'attr') . '"';
            $output[] = '<script ' . implode(' ', $parts) . '></script>';
        }
        return implode("\n", $output);
    }
}
