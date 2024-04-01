<?php

declare(strict_types=1);

namespace Modules\Documents\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

final class UploadDocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                File::types(['html'])->max(5 * 1024),
            ],
        ];
    }
}
