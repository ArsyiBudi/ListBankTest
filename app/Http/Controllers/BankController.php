<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Menampilkan list bank.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBankList(Request $request)
    {
        // Mendapatkan data list bank dari sumber data (misal: database)
        $banks = $this->retrieveBankListFromDatabase($request->input('filter'));

        // Mengembalikan response JSON dengan data list bank
        return response()->json(['data' => $banks]);
    }

    /**
     * Contoh fungsi untuk mendapatkan list bank dari database.
     *
     * @param string|null $filter
     * @return array
     */
    private function retrieveBankListFromDatabase($filter = null)
{
    // Contoh implementasi untuk mendapatkan list bank dari database
    // Di sini kita anggap ada array statis sebagai contoh
    $banks = [
        ['bank_code' => '001', 'bank_name' => 'BCA'],
        ['bank_code' => '002', 'bank_name' => 'BRI'],
        ['bank_code' => '003', 'bank_name' => 'BNI'],
        ['bank_code' => '003', 'bank_name' => 'Bank Mandiri'],
        ['bank_code' => '004', 'bank_name' => 'Bank Central Asia'],
    ];

    // Jika ada filter, kita filter array berdasarkan karakter yang dicari
    if ($filter && strlen($filter) >= 3) {
        $banks = array_filter($banks, function ($bank) use ($filter) {
            // Ubah nama bank dan filter menjadi huruf kecil untuk pencarian yang tidak case-sensitive
            $bankName = strtolower($bank['bank_name']);
            $filterLower = strtolower($filter);

            // Cocokkan filter dengan nama bank
            return strpos($bankName, $filterLower) !== false;
        });
    }

    return $banks; // mengembalikan hasil tanpa array_values()
}

}
