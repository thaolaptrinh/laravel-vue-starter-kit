<?php

declare(strict_types=1);

namespace App\Http\Requests\Settings;

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

final class ProfileUpdateRequest extends FormRequest
{
    use ProfileValidationRules;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, Unique|array<mixed>|string>>
     */
    public function rules(): array
    {
        $user = $this->user();

        abort_unless($user instanceof User, 403);

        return $this->profileRules($user->id);
    }
}
