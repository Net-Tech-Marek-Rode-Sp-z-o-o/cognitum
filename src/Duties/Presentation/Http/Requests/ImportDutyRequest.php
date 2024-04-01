<?php

declare(strict_types=1);

namespace Modules\Duties\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ImportDutyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'document_id' => [
                'required',
                'uuid',
            ],
        ];
    }
}
