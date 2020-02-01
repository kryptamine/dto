# Laravel DTO

[![Latest Stable Version](https://poser.pugx.org/kryptamine/dto/v/stable)](https://packagist.org/packages/kryptamine/dto)
[![Total Downloads](https://poser.pugx.org/kryptamine/dto/downloads)](https://packagist.org/packages/kryptamine/dto)
[![License](https://poser.pugx.org/kryptamine/dto/license)](https://packagist.org/packages/kryptamine/dto)
## Installation

You can install the package via composer:

```bash
composer require kryptamine/dto
```

## Introduction

Working with arrays is painfully.
This package represents simple trait that can makes your life easier. 
It gives you an ability to convert arrays to Data Transfer Objects and validates 
it using laravel validator facade.

Here are a couple of examples:

```php
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
```

Then you can easily do:
```php
    try {
        $dto = UserDTO::fromArray([
            'id' => 1,
            'name' => 'Alex',
            'avatar_url' => 'http://google.com'
        ]); 
        
        dd($dto->toArray(), json_encode($dto));
    } catch (ValidationException $exception) {
        dd($exception->errors());
    } 
```

## Samples
Samples can be found in `/tests/Unit/Samples`
