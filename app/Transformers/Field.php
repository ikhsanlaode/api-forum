<?php

namespace App\Transformers;


/**
*  Class Field is transformers from raw data to json view
*/
class Field
{
	public static function visible($data,$fields = 'id')
    {	
        $arrayField = explode(',', $fields);
        // foreach($data as $dt){
            foreach($arrayField as $field){
              $data->makeVisible($field);
            }
        // }
        return $data;
    }
}


