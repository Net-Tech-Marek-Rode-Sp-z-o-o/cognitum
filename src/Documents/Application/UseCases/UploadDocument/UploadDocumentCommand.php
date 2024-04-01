<?php

declare(strict_types=1);

namespace Modules\Documents\Application\UseCases\UploadDocument;

use Component\Bus\CommandBus\CommandHandler;
use Component\Bus\CommandBus\CommandInterface;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\UuidInterface;

#[CommandHandler(UploadDocumentCommandHandler::class)]
final readonly class UploadDocumentCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $id,
        public UploadedFile $file,
    ) {
    }
}
