<?php

namespace App\Core\Application;

use App\Core\Application\Interfaces\ApiResponseInterface;

class ApiResponse implements ApiResponseInterface
{
    private \stdClass $status;
    private \stdClass $payload;

    public static function create(bool $statusError, string $statusMessage, \stdClass $payload): ApiResponseInterface
    {
        $oApiResponse = new self();
        $oApiResponse->status = new \stdClass();
        $oApiResponse->setStatusError($statusError);
        $oApiResponse->setStatusMessage($statusMessage);
        $oApiResponse->setPayload($payload);

        return $oApiResponse;
    }

    public function setStatusError(bool $error): void
    {
        $this->status->error = $error;
    }

    public function setStatusMessage(string $message): void
    {
        $this->status->message = $message;
    }

    public function setPayload(\stdClass $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
