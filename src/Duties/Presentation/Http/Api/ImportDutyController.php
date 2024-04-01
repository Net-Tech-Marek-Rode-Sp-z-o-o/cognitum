<?php

declare(strict_types=1);

namespace Modules\Duties\Presentation\Http\Api;

use Component\Bus\CommandBus\CommandBus;
use Illuminate\Http\JsonResponse;
use Modules\Duties\Application\UseCases\ImportDuty\ImportDutyCommand;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Modules\Duties\Presentation\Http\Requests\ImportDutyRequest;
use Symfony\Component\HttpFoundation\Response;

final readonly class ImportDutyController
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(string $type, ImportDutyRequest $request): JsonResponse
    {
        try {
            $this->commandBus->dispatch(new ImportDutyCommand(
                type: DutyTypeEnum::from($type),
                documentId: $request->input('document_id'),
            ));

            return new JsonResponse(status: Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            dd($e);
            return new JsonResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
