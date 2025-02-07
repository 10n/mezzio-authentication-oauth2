<?php

declare(strict_types=1);

namespace MezzioTest\Authentication\OAuth2;

use Generator;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\ResourceServer;
use Mezzio\Authentication\OAuth2\Exception;
use Mezzio\Authentication\OAuth2\ResourceServerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

class ResourceServerFactoryTest extends TestCase
{
    use ProphecyTrait;

    private const PUBLIC_KEY = __DIR__ . '/TestAsset/public.key';

    private const PUBLIC_KEY_EXTENDED = [
        'key_or_path'           => self::PUBLIC_KEY,
        'pass_phrase'           => 'test',
        'key_permissions_check' => false,
    ];

    protected function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testConstructor()
    {
        $factory = new ResourceServerFactory();
        $this->assertInstanceOf(ResourceServerFactory::class, $factory);
    }

    public function testInvokeWithEmptyConfig()
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn([]);
        $factory = new ResourceServerFactory();

        $this->expectException(Exception\InvalidConfigException::class);
        $factory($this->container->reveal());
    }

    public function testInvokeWithConfigWithoutRepository()
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn([
            'authentication' => [
                'public_key' => self::PUBLIC_KEY,
            ],
        ]);
        $this->container
            ->has(AccessTokenRepositoryInterface::class)
            ->willReturn(false);

        $factory = new ResourceServerFactory();

        $this->expectException(Exception\InvalidConfigException::class);
        $factory($this->container->reveal());
    }

    public function testInvokeWithConfigAndRepository()
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn([
            'authentication' => [
                'public_key' => self::PUBLIC_KEY,
            ],
        ]);
        $this->container
            ->has(AccessTokenRepositoryInterface::class)
            ->willReturn(true);
        $this->container
            ->get(AccessTokenRepositoryInterface::class)
            ->willReturn(
                $this->prophesize(AccessTokenRepositoryInterface::class)->reveal()
            );

        $factory        = new ResourceServerFactory();
        $resourceServer = $factory($this->container->reveal());
        $this->assertInstanceOf(ResourceServer::class, $resourceServer);
    }

    public function getExtendedKeyConfigs(): Generator
    {
        $extendedConfig = self::PUBLIC_KEY_EXTENDED;

        yield [$extendedConfig];

        unset($extendedConfig['pass_phrase']);
        yield [$extendedConfig];

        unset($extendedConfig['key_permissions_check']);
        yield [$extendedConfig];
    }

    /**
     * @dataProvider getExtendedKeyConfigs
     */
    public function testInvokeWithValidExtendedKey(array $keyConfig)
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn([
            'authentication' => [
                'public_key' => $keyConfig,
            ],
        ]);
        $this->container
            ->has(AccessTokenRepositoryInterface::class)
            ->willReturn(true);
        $this->container
            ->get(AccessTokenRepositoryInterface::class)
            ->willReturn(
                $this->prophesize(AccessTokenRepositoryInterface::class)->reveal()
            );

        $factory        = new ResourceServerFactory();
        $resourceServer = $factory($this->container->reveal());
        $this->assertInstanceOf(ResourceServer::class, $resourceServer);
    }

    public function getInvalidExtendedKeyConfigs(): Generator
    {
        $extendedConfig = self::PUBLIC_KEY_EXTENDED;

        unset($extendedConfig['key_or_path']);
        yield [$extendedConfig];
    }

    /**
     * @dataProvider getInvalidExtendedKeyConfigs
     */
    public function testInvokeWithInvalidExtendedKey(array $keyConfig)
    {
        $this->container->has('config')->willReturn(true);
        $this->container->get('config')->willReturn([
            'authentication' => [
                'public_key' => $keyConfig,
            ],
        ]);
        $this->container
            ->has(AccessTokenRepositoryInterface::class)
            ->willReturn(true);
        $this->container
            ->get(AccessTokenRepositoryInterface::class)
            ->willReturn(
                $this->prophesize(AccessTokenRepositoryInterface::class)->reveal()
            );

        $factory = new ResourceServerFactory();

        $this->expectException(Exception\InvalidConfigException::class);
        $factory($this->container->reveal());
    }
}
