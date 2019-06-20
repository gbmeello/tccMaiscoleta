<?php

namespace App\Dashboard;


use Carbon\Carbon;
use RangeException;

class DashboardHelper
{
    /**
     * Converte a data passada para Carbon
     * @param $date
     * @return Carbon|string
     */
    static public function convertDate($date) {
        if(empty($date)) {
            return Carbon::now()->toDateString();
        } else {
            return Carbon::parse($date);
        }
    }

    /**
     * Concatena os valores e labels em um array associativo
     * @param array $labels titulos dos valores
     * @param array $values valores
     * @param string $name nome do array
     * @throws RangeException
     * @return array Array concatenado
     */
    static public function concatValues($labels, $values, $name = null) {
        $array = [];

        if(count($labels) != count($values)) {
            throw new RangeException('Os labels e os values devem ser do mesmo tamanho');
        }

        $total = count($values);
        if(!empty($name)) {
            for($i = 0; $i < $total; $i++) {
                $array[$name][$i]['label'] = $labels[$i];
                $array[$name][$i]['value'] = $values[$i];
            }
        } else {
            for($i = 0; $i < $total; $i++) {
                $array[$i]['label'] = $labels[$i];
                $array[$i]['value'] = $values[$i];
            }
        }

        return $array;
    }

    /**
     * Concatena os valores e labels em um json formatado
     * @param string $name nome do array
     * @param array $labels titulos dos valores
     * @param array $values valores
     * @return string Json formatado
     */
    static public function concatValuesToJson($name, $labels, $values) {
        $array = self::concatValues($name, $labels, $values);
        return json_encode($array, JSON_PRETTY_PRINT);
    }

    /**
     * Prepara o array para ser exibido no Smallbox com as informações
     * adiocionais passadas
     * @param array $data Array com os dados
     * @param mixed $label Label a ser exibida no smallbox
     * @param array $linkedInfoDictionary Array com o dicionario de dados a serem lincados
     * a um novo array para exibição na view
     * @return array Retorna array preenchido
     */
    static public function prepareSmallboxInfo($data, $label = '', $linkedInfoDictionary = [])
    {
        $ret = [];
        $ret['text'] = $label;
        $ret['number'] = 0;

        if (!empty($data)) {

            $indice = 0;
            $dataSize = count($data);
            $dictionarySize = count($linkedInfoDictionary);
            $ret['number'] = $dataSize;

            foreach ($data as $dataKey => $dataValue) {
                foreach ($linkedInfoDictionary as $htmlKey => $arrayKey) {

                    $header = null;
                    $hasOptions = strpos($arrayKey, '|');

                    //verifica se há opções adicionais
                    if($hasOptions !== false) {
                        $header = explode('|', $arrayKey)[0];
                    } else {
                        $header = $arrayKey;
                    }

                    //adiciona cabeçalhos
                    if($indice < $dictionarySize) {
                        $ret['tableModel']['header'][$indice] = $header;
                        $indice++;
                    }

                    $filterValue = empty($dataValue[$htmlKey]) ? '-' : $dataValue[$htmlKey];

                    //verifica se há opções adicionais
                    if($hasOptions !== false && $filterValue !== '-') {
                        self::filterOptions($arrayKey, $filterValue);
                    }

                    $ret['tableModel']['body'][$dataKey][$header] = $filterValue;
                }
            }

        }
        return $ret;
    }

    static public function filterOptions($arrayKey, &$value) {
        $explodeOptions = explode('|', $arrayKey);
        foreach($explodeOptions as $option) {
            switch (trim($option)) {
                case 'formatmoney':
                    $value = number_format(doubleval($value), 2, ',', '.');
                    break;
                case 'formatdate':
                    $value = Carbon::parse($value)->format('d/m/Y');
                    break;
                case 'formatdatetime':
                    $value = Carbon::parse($value)->format('d/m/Y H:i:s');
                    break;
                case 'formatdecimal':
                    $value = number_format(doubleval($value), 2, ',');
                    break;
                default:
                    break;
            }
        }
    }

    static public function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if($ini == 0)
            return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}