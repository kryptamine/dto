<?php

declare(strict_types=1);

namespace Kryptamine\DTO\Tests;

use Illuminate\Validation\ValidationException;
use Kryptamine\DTO\Tests\Unit\DTOSamples\PostDTO;
use Kryptamine\DTO\Tests\Unit\DTOSamples\UserDTO;
use Orchestra\Testbench\TestCase;


/**
 * Class DTOTest
 * @package Kryptamine\DTO\Tests
 */
class DTOTest extends TestCase
{
    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                'with correct data contract' => [
                    'id' => 1,
                    'name' => 'Alex',
                    'avatar_url' => 'http://google.com'
                ],
                false
            ],
            [
                'with invalid url' => [
                    'id' => 2,
                    'name' => 'Alex',
                    'avatar_url' => 'test'
                ],
                true
            ],
            [
                'with invalid id' => [
                    'id' => 'text id',
                    'name' => 'Alex',
                    'avatar_url' => 'http://google.com'
                ],
                true
            ],
            [
                'with empty data' => [],
                true
            ]
        ];
    }


    /**
     * @test
     * @dataProvider dataProvider
     * @param $data
     * @param $shouldThrowException
     * @throws ValidationException
     */
    public function validatesCorrectly(array $data, bool $shouldThrowException): void
    {
        if ($shouldThrowException) {
            $this->expectException(ValidationException::class);
        }

        $dto = UserDTO::fromArray($data);

        $this->assertEquals($dto->toArray(), $data);
    }

    /**
     * @test
     * @throws ValidationException
     */
    public function nestedDTOInstantiatesFromArray(): void
    {
        $data = [
            'id' => 1,
            'body' => 'test post',
            'user' => [
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ],
            'comments' => [
                ['id' => 1, 'text' => 'comment', 'author' => 'Alex']
            ]
        ];

        $post = PostDTO::fromArray($data);

        $this->assertSame($data, $post->toArray());
    }

    /**
     * @test
     * @throws ValidationException
     */
    public function nestedDTOConvertsToJson(): void
    {
        $data = [
            'id' => 1,
            'body' => 'test post',
            'user' => [
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ],
            'comments' => [
                ['id' => 1, 'text' => 'comment', 'author' => 'Alex']
            ]
        ];

        $post = PostDTO::fromArray($data);

        $this->assertSame(json_encode($data), json_encode($post));


        try {
            $dto = UserDTO::fromArray([
                'id' => 1,
                'name' => 'Alex',
                'avatar_url' => 'http://google.com'
            ]);
        } catch (ValidationException $exception) {
            dd($exception->errors());
        }
    }
}
