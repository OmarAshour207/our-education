<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TranactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = File::get('public/data/transactions.json');
        $transactions = json_decode($transactions, true)['transactions'];

        foreach($transactions as $transaction) {
            Transaction::create([
                'paidAmount'    => $transaction['paidAmount'],
                'parentEmail'   => $transaction['parentEmail'],
                'currency'      => $transaction['Currency'],
                'statusCode'    => $transaction['statusCode'],
                'paymentDate'   => $transaction['paymentDate'],
                'parentIdentification'  => $transaction['parentIdentification']
            ]);
        }
    }
}
