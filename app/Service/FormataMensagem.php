<?php

namespace App\Service;

/**
 * Template para mensagens de erro e sucesso do aplicativo
 * 
 */
class FormataMensagem
{
    private $estrutura_msg;
    private $color_mensagem = ['success', 'danger'];
    private $tipo_mensagem = ['Success', 'Danger'];
    private $icone_mensagem = ['#check-circle-fill', '#exclamation-triangle-fill'];
    private $div_notificacoa = ['notificacao', 'notificacao-update'];

    public function padraoMensagem($status, $ps, $ps2, $ps3, $ps4, $campo, $limpar_campos = null)
    {
        $this->estrutura_msg = [
            'status' => $status,
            'tipo_alerta' => $this->color_mensagem[$ps],
            'tipo_alert_2' => $this->tipo_mensagem[$ps2],
            'icone' => $this->icone_mensagem[$ps3],
            'div_notificacao' => $this->div_notificacoa[$ps4],
            'campo' => $campo,
            'limpar_campos' => $limpar_campos
        ];
    }


    public function getFormataMensagem()
    {
        return $this->estrutura_msg;
    }
}
