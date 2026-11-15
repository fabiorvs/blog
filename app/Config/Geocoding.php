<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Geocoding extends BaseConfig
{
    /** Serviço de geocodificação; pode ser trocado sem alterar o cadastro. */
    public string $endpoint = 'https://nominatim.openstreetmap.org/search';

    /** Serviço postal usado para transformar CEP brasileiro em endereço pesquisável. */
    public string $cepEndpoint = 'https://viacep.com.br/ws';

    /** Identifica a aplicação nas consultas ao serviço. */
    public string $userAgent = 'Blog Capoeira/1.0 (+http://localhost:8080/)';

    /** Mantém resultados para evitar consultas repetidas ao mesmo endereço. */
    public int $cacheTtl = 2_592_000;
}
