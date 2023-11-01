<?php

namespace App\Http\Controllers\Apps;

use Inertia\Inertia;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Profit;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransactionsListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ public function index()
    {
        $transactions = DB::table('transactions')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('users', 'transactions.cashier_id', '=', 'users.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'transactions.*',
                'transaction_details.*',
                'customers.name as customer_name',
                'products.title as product_title',
                'products.barcode',
                'categories.name as category_name',
                'users.name as cashier_name'
            )
            ->when(request()->q, function ($query) {
                $query->where('transactions.title', 'like', '%' . request()->q . '%');
            })
            ->latest('transactions.created_at') // Menentukan tabel 'transactions' untuk 'created_at'
            ->paginate(5);
        // dd($transactions);
        // Return Inertia view (this won't be reached if you use dd() above)
        return Inertia::render('Apps/ListTransactions/Index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan transaksi yang akan dihapus
        $transaction = Transaction::findOrFail($id);

        // Temukan semua baris di tabel transaction_details yang merujuk ke transaksi ini
        $relatedDetails = TransactionDetail::where('transaction_id', $id)->get();

        // Hapus semua baris terkait di tabel transaction_details
        foreach ($relatedDetails as $detail) {
            $detail->delete();
        }

        // Hapus juga baris-baris di tabel profits yang merujuk ke transaksi ini
        Profit::where('transaction_id', $id)->delete();

        // Setelah menghapus baris terkait, Anda dapat menghapus transaksi
        $transaction->delete();

        // Redirect ke halaman yang sesuai
        return redirect()->route('apps.transactions-list.index');
    }
}
