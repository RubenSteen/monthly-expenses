<?php

namespace App\Http\Requests;

use App\Rules\PiggyBankIsFromUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->id !== $this->category->user_id) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'amount' => 'required',
            'to_id' => ['required', new PiggyBankIsFromUser()],
            'from_id' => ['required', new PiggyBankIsFromUser()],
        ];
    }
}
