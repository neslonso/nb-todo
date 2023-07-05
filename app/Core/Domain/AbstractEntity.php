<?php

namespace App\Core\Domain;

abstract class AbstractEntity implements \JsonSerializable
{
    protected ?int $id;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $data): static
    {
        $oResult = new static();
        $oResult->id = $data['id'] ?: null;
        foreach ($data as $key => $value) {
            if (method_exists($oResult, 'set'.ucfirst($key))) {
                $oResult->{'set'.ucfirst($key)}($value);
            }
        }

        return $oResult;
    }

    public static function fromArrayOfArrays(array $data): array
    {
        $aResult = [];
        foreach ($data as $item) {
            $aResult[] = static::fromArray($item);
        }

        return $aResult;
    }
}
