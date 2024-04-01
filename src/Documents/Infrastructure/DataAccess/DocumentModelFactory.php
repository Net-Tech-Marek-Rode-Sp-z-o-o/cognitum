<?php

declare(strict_types=1);

namespace Modules\Documents\Infrastructure\DataAccess;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Documents\Domain\Enums\DocumentDiskEnum;

/**
 * @extends Factory<DocumentModel>
 */
final class DocumentModelFactory extends Factory
{
    protected $model = DocumentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $file = UploadedFile::fake()->createWithContent('document.html', $this->faker->randomHtml());
        $path = $file->store('documents', ['disk' => DocumentDiskEnum::LOCAL->value]);

        return [
            'id' => $this->faker->uuid(),
            'name' => $file->hashName(),
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => $path,
            'size' => $file->getSize(),
            'disk' => DocumentDiskEnum::LOCAL->value,
        ];
    }

    public function withFileContent(string $content): self
    {
        return $this->state(function (array $attributes) use ($content) {
            $file = UploadedFile::fake()->createWithContent('document.html', $content);
            $path = $file->store('documents', ['disk' => DocumentDiskEnum::LOCAL->value]);

            return [
                'id' => $this->faker->uuid(),
                'name' => $file->hashName(),
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'path' => $path,
                'size' => $file->getSize(),
                'disk' => DocumentDiskEnum::LOCAL->value,
            ];
        });
    }
}
