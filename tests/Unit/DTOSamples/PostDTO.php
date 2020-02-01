<?php

namespace Kryptamine\DTO\Tests\Unit\DTOSamples;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use JsonSerializable;
use Kryptamine\DTO\DTOTrait;

/**
 * Class PostDTO
 * @package Kryptamine\DTO\Tests\Unit\DTOSamples
 */
class PostDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $body;

    /**
     * @var UserDTO
     */
    private $user;

    /**
     * @var CommentDTO[]
     */
    private $comments;

    /**
     * PostDTO constructor.
     * @param int $id
     * @param string $body
     * @param UserDTO $user
     * @param array $comments
     */
    public function __construct(int $id, string $body, UserDTO $user, array $comments)
    {
        $this->id = $id;
        $this->body = $body;
        $this->user = $user;
        $this->comments = $comments;
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
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        return $this->user;
    }

    /**
     * @return CommentDTO[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $data
     * @return PostDTO
     * @throws ValidationException
     */
    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'body'),
            UserDTO::fromArray(Arr::get($data, 'user')),
            self::mapArrayToDTO(
                CommentDTO::class,
                Arr::get($data, 'comments', [])
            )
        );
    }

    /**
     * @return array
     */
    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'body' => 'required|string|max:500',
            'user' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user->toArray(),
            'comments' => self::mapToArray($this->comments)
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
