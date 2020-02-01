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
class CommentDTO implements Arrayable, JsonSerializable
{
    use DTOTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $author;

    /**
     * CommentDTO constructor.
     * @param int $id
     * @param string $text
     * @param string $author
     */
    public function __construct(int $id, string $text, string $author)
    {
        $this->id = $id;
        $this->text = $text;
        $this->author = $author;
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @inheritDoc
     */
    protected static function createFromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'text'),
            Arr::get($data, 'author')
        );
    }

    /**
     * @return array
     */
    protected static function validationRules(): array
    {
        return [
            'id' => 'required|integer',
            'text' => 'required|string|max:500',
            'author' => 'required|string|max:255',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'author' => $this->author
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
