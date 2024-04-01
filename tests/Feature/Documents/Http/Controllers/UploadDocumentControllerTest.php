<?php

declare(strict_types=1);

namespace Tests\Feature\Documents\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;
use Tests\TestCase;

final class UploadDocumentControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake(DocumentDiskEnum::LOCAL->value);
    }

    public function testUploadingDocument(): void
    {
        $file = UploadedFile::fake()->create('document.html', 1024);

        $response = $this->postJson(route('documents.upload'), [
            'file' => $file,
        ]);

        $response->assertCreated();
        $response->assertJsonStructure(['id']);
    }

    /**
     * @dataProvider provideInvalidPayloadData
     */
    public function testUploadingInvalidDocument(array $dataPayload, array $expectedError): void
    {
        $response = $this->postJson(route('documents.upload'), $dataPayload);

        $response->assertUnprocessable()->assertJsonValidationErrors($expectedError);
    }

    public static function provideInvalidPayloadData(): array
    {
        return [
            'missing file' => [
                [],
                [
                    'file' => [
                        'The file field is required.',
                    ],
                ],
            ],
            'invalid file type' => [
                [
                    'file' => UploadedFile::fake()->create('document.pdf', 1024),
                ],
                [
                    'file' => [
                        'The file field must be a file of type: html.',
                    ],
                ],
            ],
            'file to large' => [
                [
                    'file' => UploadedFile::fake()->create('document.html', 6 * 1024),
                ],
                [
                    'file' => [
                        'The file field must not be greater than 5120 kilobytes.',
                    ],
                ],
            ],
        ];
    }
}
