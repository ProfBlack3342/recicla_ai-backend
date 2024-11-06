<?php
/*
    Instalando o phpUnit:

    composer require --dev phpunit/phpunit


    Para testar se o PHPUnit foi devidamente instalado execute o 
    comando abaixo na raiz do projeto:

    composer show phpunit/phpunit


    Veja também: https://php.com.br/24?testes-unitarios-com-a-phpunit
*/

namespace Nawarian\ArchiveOrg\Test;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testClientFetchesMetadata(): void
    {
        $client = new \Nawarian\ArchiveOrg\Client();

        $metadata = $client->fetchMetadata('nawarian-test');

        $this->assertSame('nawarian-test', $metadata->identifier());
        $this->assertSame('2019-02-19 20:00:38', $metadata->publicDate());
        $this->assertSame('opensource', $metadata->collection());
    }
}

?>