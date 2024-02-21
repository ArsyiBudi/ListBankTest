<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class BankAPITest extends TestCase
{
    /**
     * Test scenario: load bank list.
     *
     * @return void
     */
    public function testLoadBankList()
    {
        // Membuat request POST ke endpoint /api/bank/list
        $response = $this->postJson('/api/bank/list');

        // Memastikan status response adalah 200 (OK)
        $response->assertStatus(200);

        // Memastikan response memiliki format JSON
        $response->assertJsonStructure([
            'data',
        ]);
    }

    /**
     * Test scenario: load bank list with filter => three.
     *
     * @return void
     */
    public function testLoadBankListWithFilterThreeOrMore()
    {
        // Membuat request POST ke endpoint /api/bank/list dengan parameter filter
        $response = $this->postJson('/api/bank/list', ['filter' => 'BCA']);

        // Memastikan status response adalah 200 (OK)
        $response->assertStatus(200);

        // Memastikan response memiliki format JSON
        $response->assertJsonStructure([
            'data',
        ]);

        // Memeriksa apakah 'data' ada dalam response JSON
        $response->assertJsonCount(1, 'data');

        // Memeriksa apakah bank yang diharapkan (BCA) ada dalam response
        $response->assertJsonFragment([
            'bank_name' => 'BCA',
        ]);
    }


     /**
     * Test scenario: load bank list with filter.
     *
     * @return void
     */
    public function testLoadBankListWithFilterLessThanThree()
{
    // Membuat request POST ke endpoint /api/bank/list dengan parameter filter
    $response = $this->postJson('/api/bank/list', ['filter' => 'BA']);

    // Menampilkan hasil response untuk debugging
    $responseData = $response->json();
    var_dump($responseData);

    // Memastikan status response adalah 422 (Unprocessable Entity)
    $response->assertStatus(422);

    // Memastikan response memiliki format JSON
    $response->assertJson();

    // Memeriksa apakah 'errors' ada dalam response JSON
    $response->assertJsonStructure([
        'message',
        'errors' => [
            'filter',
        ],
    ]);

    // Memeriksa apakah pesan error sesuai dengan yang diharapkan
    $response->assertJsonFragment([
        'message' => 'The given data was invalid.',
        'errors' => [
            'filter' => [
                'The filter must be at least 3 characters.',
            ],
        ],
    ]);
}

}
