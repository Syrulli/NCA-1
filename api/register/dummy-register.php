<?php

    include '../../Database/database.php';
    include '../../Controller/controller.php';
    include '../_r/reusable.php';

    $feedback = array(
        [
            //0
            'status'=>'410',
            'feedback'=>'Username already exists',
        ],
        [
            //1
            'status'=>'411',
            'feedback'=>'Email address already taken',
        ],
        [
            //2
            'status'=>'412',
            'feedback'=>'Referral code doesn\'t exist',
        ],
        [
            //3
            'status'=>'200',
            'feedback'=>'Registration Successful!',
            'url'=>'../login',
        ],
        [
            //4
            'status'=>'201',
            'feedback'=>'Internal Server Error',
            'sub_feedback'=>'Please try again',
        ],
        [
            //5
            'status'=>'413',
            'feedback'=>'Please enter required fields',
        ],
        [
            //6
            'status'=>'414',
            'feedback'=>'Email is Invalid',
        ],
        [
            //7
            'status'=>'415',
            'feedback'=>'Username should consists of letters and numbers',
        ],
        [
            //8
            'status'=>'416',
            'feedback'=>'Password should consists of letters and numbers',
        ]
    );

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        header('Content-Type: application/json');

        $output = array();

        $required_fields = [
            ['nickname','alphanum'],
            ['password','alphanum'],
            ['email','email'],
            ['code','numeric'],
        ];  

        if( required_fields_validated($required_fields, $_REQUEST) == 0 )
        {
            if( username_exists( $_REQUEST['nickname'] ) )
            {
                array_push($output, $feedback[0]);
            }

            if( email_used( $_REQUEST['email'] ) )
            {
                array_push($output, $feedback[1]);
            }

            if( !referral_code_exists( $_REQUEST['code'] ) )
            {
                array_push($output, $feedback[2]);
            }
            

            if( count( $output ) == 0 )
            {

                $FORMATTED_DATA = format_user_input($_REQUEST);

                if( exec_register($FORMATTED_DATA) )
                {
                    array_push($output, $feedback[3]);
                }
                else
                {
                    array_push($output, $feedback[4]);
                }

            }

        }
        else if ( is_array(required_fields_validated($required_fields, $_REQUEST)) )
        {
            $validation_feedback = required_fields_validated($required_fields, $_REQUEST);

            foreach ($validation_feedback as $key => $val) {

                if( $val[0] == 1 )
                {
                    array_push($output, $feedback[5]);
                }
                if( $val[0] == 2 )
                {
                    if( $val[1] == 'nickname' )
                    {
                        array_push($output, $feedback[7]);
                    }

                    if( $val[1] == 'password' )
                    {
                        array_push($output, $feedback[8]);
                    }
                }
                if( $val[0] == 3 )
                {
                    if( $val[1] == 'email' )
                    {
                        array_push($output, $feedback[6]);
                    }
                }
            }
        }
      
        echo json_encode($output);
            
    }

    function exec_register( $data ){

        $count = count( $data );

        $counter = 1;

        $values = array();

        $c = new controller();

        $sql = '
                    INSERT INTO
                                profile
                                (
                                    nickname,
                                    password,
                                    code,
                                    email
                                )
                    VALUES
                                (
        ';

        foreach ($data as $key => $value) {

            if( $counter == $count)
            {
                $sql .= ':' .$key;
            }
            else
            {
                $sql .= ':' .$key. ',';
            }

            $counter++;

            $values[$key] = $data[$key];

        }

        $sql .= ')';

        $data = [
            'sql' => $sql,
            'values'=>$values
        ];

        if( $c->store($data) )
        {   
            return true;
        }
        else
        {
            return false;
        }
    }

    function username_exists( $username ){

        $c = new controller();

        $sql = '  
                    SELECT 
                            * 
                    FROM 
                            users
                    WHERE
                            nickname = ?
                ';

        $data = [
                    'sql' => $sql,
                    'where'=>[$username]
        ];

        if ( count( $c->fetch($data) ) > 0 )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    function email_used( $email ){

        $c = new controller();

        $sql = '  
                    SELECT 
                            * 
                    FROM 
                            users
                    WHERE
                            email = ?
                ';

        $data = [
                    'sql' => $sql,
                    'where'=>[$email]
        ];

        if ( count( $c->fetch($data) ) > 0 )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    function referral_code_exists( $code ){

        $c = new controller();

        $sql = '  
                    SELECT 
                            * 
                    FROM 
                            agents
                    WHERE
                            referral_code = ?
                ';

        $data = [
                    'sql' => $sql,
                    'where'=>[$code]
        ];

        if ( count( $c->fetch($data) ) > 0 )
        {
            return true;
        }
        else
        {
            return false;
        }

    }



?>