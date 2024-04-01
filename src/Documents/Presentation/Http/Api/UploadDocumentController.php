<?php

declare(strict_types=1);

namespace Modules\Documents\Presentation\Http\Api;

use Component\Bus\CommandBus\CommandBus;
use Illuminate\Http\JsonResponse;
use Modules\Documents\Application\UseCases\UploadDocument\UploadDocumentCommand;
use Modules\Documents\Presentation\Http\Requests\UploadDocumentRequest;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final readonly class UploadDocumentController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(UploadDocumentRequest $request): JsonResponse
    {
        try {
            $this->commandBus->dispatch(new UploadDocumentCommand(
                id: $id = Uuid::uuid4(),
                file: $request->file('file'),
            ));

            return new JsonResponse(['id' => $id->toString()], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
