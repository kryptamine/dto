<?php

namespace Kryptamine\DTO\Tests\Unit\DTOSamples;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use JsonSerializable;
use Kryptamine\DTO\DTOTrait;

/**
 * Class PostDTO
 * @package Kryptamine\DTO\Tests\Unit\DTOSamples
 */
class UserDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $avatarUrl;

    /**
     * UserDTO constructor.
     * @param int $id
     * @param string $name
     * @param string $avatarUrl
     */
    public function __construct(int $id, string $name, string $avatarUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    /**
     * @inheritDoc
     */
    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'avatar_url')
        );
    }

    /**
     * @return array
     */
    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'avatar_url' => 'required|string|url',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar_url' => $this->avatarUrl
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
