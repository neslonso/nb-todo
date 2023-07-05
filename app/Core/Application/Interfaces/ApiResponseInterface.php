<?php

namespace App\Core\Application\Interfaces;

interface ApiResponseInterface extends \JsonSerializable
{
    public static function create(bool $statusError, string $statusMessage, \stdClass $payload): ApiResponseInterface;

    public function setStatusError(bool $error): void;

    public function setStatusMessage(string $message): void;

    public function setPayload(\stdClass $payload): void;
}
