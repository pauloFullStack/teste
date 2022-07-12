<?php

namespace App\Service;

use Illuminate\Support\Facades\Validator;

/**
 * Valida campos do formulario
 * 
 */

class ValidacaoCampos
{


    private $status;

    public function __construct($request, $campos)
    {

        if ($campos == 'store') {
            $campos = $this->getStore();
        } else if ($campos == 'update') {
            $campos = $this->getUpdate();
        }

        $validator = Validator::make($request->all(), $campos);

        if ($validator->fails()) {
            $this->status = response()->json(['error' => $validator->errors()->all()])->original['error'][0];
        } else {
            $this->status = response()->json(['status' => 'ok'])->original;
        }
    }

    public function getValidacaoCampos()
    {
        return $this->status;
    }

    public function getStore()
    {
        return ['nome' => 'required', 'valor' => 'required|numeric|min:0|not_in:0', 'marca' => 'required', 'fabricante' => 'required', 'estoque' => 'required|numeric|min:0|not_in:0', 'cidade' => 'required'];
    }

    public function getUpdate()
    {
        return ['nome' => 'required', 'valor' => 'required|numeric|min:0|not_in:0', 'cidade' => 'required', 'estoque' => 'required|numeric|min:0', 'marca' => 'required', 'fabricante' => 'required'];
    }

    public function setStatusStore($result)
    {
        return $result == 'The selected valor is invalid.' || $result == 'The estoque must be at least 0.' || $result == 'The selected estoque is invalid.' ? 'O campo VALOR e ESTOQUE devem ser maior que 0!' : 'Preencha o campo ' . (explode(' ', $result))[1];
    }

    public function setStatusUpdate($result)
    {
        return $result == 'The selected valor is invalid.' || $result == 'The estoque must be at least 0.' ? 'O campo VALOR deve ser maior que 0 e o campo ESTOQUE deve ser igual ou maior que 0!' : 'Preencha o campo ' . (explode(' ', $result))[1];
    }

    public function setStatusStore1($result)
    {
        return $result == 'The selected valor is invalid.' || $result == 'The estoque must be at least 0.' || $result == 'The selected estoque is invalid.' ? false : (explode(' ', $result))[1];
    }

    public function setStatusUpdate1($result)
    {
        return $result == 'The selected valor is invalid.' || $result == 'The estoque must be at least 0.' ? false : 'update_' . ((explode(' ', $result))[1]);
    }
}
