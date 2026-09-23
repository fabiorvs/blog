<?php
namespace App\Services;
use CodeIgniter\HTTP\RequestInterface;
class VisitTrackerService
{
    public function record(RequestInterface $request): void
    {
        $method = strtoupper($request->getMethod());
        $path = trim($request->getUri()->getPath(), '/');
        $agent = (string) $request->getUserAgent();
        if ($method !== "GET" || $path === "admin" || strpos($path, "admin/") === 0 || $path === "health" || $this->isBot($agent)) { return; }
        $db = db_connect();
        if (!$db->tableExists('visitas')) { return; }
        $country = strtoupper(trim((string) ($request->getHeaderLine('CF-IPCountry') ?: $request->getHeaderLine('CloudFront-Viewer-Country') ?: $request->getHeaderLine('X-Country-Code'))));
        if (!preg_match('/^[A-Z]{2}$/', $country) || in_array($country, ['XX','T1'], true)) { $country = null; }
        $referer = $request->getHeaderLine('Referer');
        $host = $referer !== '' ? parse_url($referer, PHP_URL_HOST) : null;
        $secret = (string) config('Encryption')->key ?: (string) config('App')->baseURL;
        $db->table('visitas')->insert([
            'caminho' => '/' . $path,
            'referencia' => $host ? mb_substr(strtolower($host), 0, 190) : null,
            'navegador' => $this->browser($agent),
            'dispositivo' => $this->device($agent),
            'pais' => $country,
            'visitante_hash' => hash_hmac('sha256', $request->getIPAddress() . '|' . $agent, $secret),
        ]);
    }
    private function isBot(string $ua): bool { return $ua === '' || preg_match('/bot|crawl|spider|slurp|preview|facebookexternalhit|whatsapp/i', $ua) === 1; }
    private function browser(string $ua): string
    {
        foreach (['Edg'=>'Edge','OPR'=>'Opera','SamsungBrowser'=>'Samsung Internet','Chrome'=>'Chrome','Firefox'=>'Firefox','Safari'=>'Safari'] as $needle=>$name) if (stripos($ua,$needle)!==false) return $name;
        return 'Outro';
    }
    private function device(string $ua): string
    {
        if (preg_match('/ipad|tablet|kindle|silk/i',$ua)) return 'Tablet';
        if (preg_match('/mobile|iphone|ipod|android/i',$ua)) return 'Celular';
        return 'Computador';
    }
}
