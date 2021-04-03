<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SalaryTest extends TestCase
{
    public function testSalaryIndex()
    {
        $this->get('salary', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'user_id',
                    'salary',
                    'date',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ],
            'meta' => [
                '*' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links',
                ]
            ]
        ]);
    }

    public function testSalaryStore(){

        $parameters = [
            'user_id' => '60649d7a3e5b0000ec006df6',
            'salary' => 7000000,
            'date' => '2021-06-01'
        ];

        $this->post('salary', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'user_id',
                    'salary',
                    'date',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]    
        );
        
    }

    public function testSalaryUpdate(){

        $parameters = [
            'user_id' => '60649d7a3e5b0000ec006df6',
            'salary' => 9000000,
            'date' => '2021-06-01'
        ];

        $this->put('salary/6065a8770e300000ec0024c3', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'user_id',
                    'salary',
                    'date',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]    
        );
    }

    public function testSalaryDestroy(){
        
        $this->delete('salary/6065a8770e300000ec0024c3', [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
                'status',
                'message'
        ]);
    }
}
