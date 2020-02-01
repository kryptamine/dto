<?php

namespace Kryptamine\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Basic DTO principles:
 * 1. Never mutate the state (DTO can only have data getters, but never setters)
 * 2. DTO can include Data filtration methods e.g. (hasSomething, findBySomething, isActive e.t.c)
 *
 * Trait DTOTrait
 * @package Kryptamine\DTO
 */
trait DTOTrait
{
    /**
     * Contains DTO instantiation logic
     *
     * @param array $data
     * @return mixed
     */
    abstract protected static function createFromArray(array $data): self;

    /**
     * Validation rules available from
     * https://laravel.com/docs/6.x/validation#available-validation-rules
     *
     * @return array
     */
    protected static function validationRules(): array
    {
        return [];
    }

    /**
     * Instantiate a new DTO class based on array
     *
     * @param array $data
     * @return DTOTrait
     * @throws ValidationException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data);

        return static::createFromArray($data);
    }

    /**
     * @param string $dto
     * @param array $data
     * @return array
     */
    private static function mapArrayToDTO(string $dto, array $data): array
    {
        return array_map([$dto, 'fromArray'], $data);
    }

    /**
     * @param array $data
     * @return array
     */
    private static function mapToArray(array $data): array
    {
        return array_map(static function (Arrayable $dto) {
            return $dto->toArray();
        }, $data);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    private static function validate(array $data): void
    {
        $validationRules = static::validationRules();
        $validator = Validator::make($data, $validationRules);

        if ($validationRules && $validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
