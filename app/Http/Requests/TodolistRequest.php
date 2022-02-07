<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodolistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'todo_list/entry' || $this->path() == 'todo_list/edit')
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['filled'],
            'item_name' => ['required'],
            'expire_date' =>  ['filled']
        ];
    }

    public function messages()
    {
        return [
            'user_id.filled' => '担当者を選択してください。',
            'item_name.required' => '項目名を記入してください。',
            'expire_date.filled' =>  '期限を選択してください。'
        ];
    }


}
