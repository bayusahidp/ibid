<?php

class UserTest extends TestCase
{
    public function testUserIndex()
    {
        $this->get('user', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'name',
                    'email',
                    'phone',
                    'job',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function testUserStore(){

        $parameters = [
            'name' => 'supermen dan betmen',
            'email' => 'supermen1@betmen.com',
            'password' => '12345678',
            'phone' => '088881235645',
            'job' => 'front end developer'
        ];

        $this->post('register', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'name',
                    'email',
                    'phone',
                    'job',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
        
    }

    public function testUserUpdate(){

        $parameters = [
            'name' => 'tes update 2',
            'phone' => '089507229772',
            'job' => 'fullstack developer'
        ];

        $this->put('user/6066d8079c17000054005e22', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'name',
                    'email',
                    'phone',
                    'job',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
    }

    public function testUserDestroy(){
        
        $this->delete('user/6066d8079c17000054005e22', []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
                'status',
                'message'
        ]);
    }
}
