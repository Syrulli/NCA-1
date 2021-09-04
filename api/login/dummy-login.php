<?php

    include '../../Database/database.php';
    include '../_r/reusable.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        header('Content-Type: application/json');

        $output = array();

        $required_fields = [
                            'nickname'=>'alphanum',
                            'password'=>''
        ];

        $feedback = array(
            [
                //0
                'status'=>'403',
                'feedback'=>'Invalid Username or Password',
            ],
            [
                //1
                'status'=>'200',
                'feedback'=>'Log-in Successful!',
                'url'=>'../dashboard/index.php',
            ],
            [
                //2
                'status'=>'401',
                'feedback'=>'Please enter required fields',
            ],
            [
                //3
                'status'=>'201',
                'feedback'=>'Internal Server Error',
                'sub_feedback'=>'Please try again',
            ],
            [
                //4
                'status'=>'413',
                'feedback'=>'Please enter required fields',
            ]

        );

        // == 0 if no error sa validations
        if( required_fields_validated( $required_fields, $_REQUEST ) == 0 )
        {
            if( checkIfUserExist( $_REQUEST ) )
            {
                array_push($output, $feedback[1]);
            }
            else
            {
                array_push($output, $feedback[0]);
            }
        }
        // 403 if may issetfield
        else if( required_fields_validated($required_fields, $_REQUEST) == 403 )
        {
            array_push($output, $feedback[2]);
        }
        // return as array if multiple yung error sa validation
        else if( is_array(required_fields_validated($required_fields, $_REQUEST)) )
        {
            $array = required_fields_validated($required_fields, $_REQUEST);

            foreach ($array as $key => $value) {

                if( $value[0] == 415 )
                {
                    // check if sinong key yung may error sa validation
                    if($value[1] == 'nickname')
                    {
                        array_push($output, [
                            'status'=>'415',
                            'feedback'=>$value[2],
                        ]);
                    }
                    
                }
            }
        
        } 
        
        /* 
            change index nalang sir para sa feedback
            regardless validations tutuloy 
        */

        // echo json_encode(
        //     [
        //         $feedback[0]
        //     ]
        // );

        /*
            but if you want it with validations 
        */
        echo json_encode($output);

  
    }

    function checkIfUserExist($data)
    {
        $db = new db();

        $sql = '  
                    SELECT 
                            * 
                    FROM 
                            profile
                    WHERE
                            nickname = ?
                    AND     
                            password = ?
                ';

        $stmt = $db->connect()->prepare($sql);

        $stmt->execute( 
                        [ 
                            $data['nickname'], 
                            $data['password'] 
                        ]
        );

        if ( count( $stmt->fetchAll() ) > 0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }



?>