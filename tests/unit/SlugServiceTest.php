<?php

use App\Services\SlugService;
use CodeIgniter\Test\CIUnitTestCase;

final class SlugServiceTest extends CIUnitTestCase
{
    public function testRemovesAccentsAndSpecialCharacters(): void
    {
        $this->assertSame('graduacao-e-cordoes', SlugService::make('Graduação e Cordões'));
        $this->assertSame('mestre-camisa-sao-paulo', SlugService::make('Mestre Camisa — São Paulo!'));
    }

    public function testCollapsesSeparatorsAndUsesFallback(): void
    {
        $this->assertSame('uma-pagina', SlugService::make('  Uma---página  '));
        $this->assertSame('conteudo', SlugService::make('***'));
    }
}
