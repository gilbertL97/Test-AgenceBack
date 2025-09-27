<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceitaLiquidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Cambia según tu lógica de autorización
    }

    public function rules()
    {
        return [
            'idUsuario'  => 'required|exists:cao_usuario,co_usuario',
            'startDate'  => 'required|date|before_or_equal:endDate',
            'endDate'    => 'required|date|after_or_equal:startDate',
        ];
    }

    public function messages()
    {
        return [
            'idUsuario.required' => 'El usuario es obligatorio.',
            'idUsuario.exists'   => 'El usuario no existe.',
            'startDate.required' => 'La fecha de inicio es obligatoria.',
            'startDate.date'     => 'La fecha de inicio debe ser una fecha válida.',
            'startDate.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha de fin.',
            'endDate.required'   => 'La fecha de fin es obligatoria.',
            'endDate.date'       => 'La fecha de fin debe ser una fecha válida.',
            'endDate.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
