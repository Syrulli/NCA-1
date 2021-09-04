<?php

function required_fields_validated($REQUIRED_FIELDS, $_POSTDATA){

    $FEEDBACK = array();

    $STATUS = 0;

    $POST_DATA_KEYS = array_keys( $_POSTDATA );

    $REQUIRED_DATA_KEYS = array_keys( $REQUIRED_FIELDS );

    if( !isset_fields( $POST_DATA_KEYS, $REQUIRED_DATA_KEYS ) )
    {
        $STATUS = 403;
    }
    else
    {
        foreach ($REQUIRED_FIELDS as $key => $v) {

            if ( $v == 'alphanum' )
            {
                if( !ctype_alnum( $_POSTDATA[$key] ) || is_numeric( $_POSTDATA[$key] ))
                {
                    array_push($FEEDBACK, [415,$key,' should consist of numbers and letters.']);
                }
            }
            else if ( $v == 'email' )
            {
                if( !filter_var( $_POSTDATA[$key] , FILTER_VALIDATE_EMAIL) )
                {
                    array_push($FEEDBACK, [$key, 'please enter a valid email']);
                }
            }
            else if ( $v == 'numeric' )
            {
                if ( !is_numeric($_POSTDATA[$key]) )
                {
                    array_push($FEEDBACK, [$key, 'input must be numbers.']);
                }
            }
        }
    }

    if( $STATUS == 403 )
    {
        return 403;
    }
    else if ( count( $FEEDBACK ) > 0 )
    {
        return $FEEDBACK;
    }
    else
    {
        return 0;
    }

}

function isset_fields($b, $a) {

    $at = array_flip($a);

    $d = array();

    foreach ($b as $i)
    {
        if (!isset($at[$i])) 
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
}

function format_user_input($_POSTDATA){

    $output = [];

    foreach ($_POSTDATA as $key => $v) 
    {
        $output[$key] = substr(strtolower($v),0,64);
    }

    return $output;
}











?>