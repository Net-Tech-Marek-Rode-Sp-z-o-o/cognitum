<?php

declare(strict_types=1);

namespace Tests\Feature\Duties\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Modules\Documents\Infrastructure\DataAccess\DocumentModelFactory;
use Modules\Duties\Domain\Enums\DutyTypeEnum;
use Tests\TestCase;

final class ImportDutyControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(DocumentDiskEnum::LOCAL->value);
    }

    public function testImportingDuties(): void
    {
        $content = file_get_contents(__DIR__.'/../../../../fixtures/dtr.html');
        $document = DocumentModelFactory::new()->withFileContent($content)->create();

        $response = $this->postJson(route('duties.import', ['type' => DutyTypeEnum::DTR->value]), [
            'document_id' => $document->getKey(),
        ]);

        $response->assertCreated();
    }
}
