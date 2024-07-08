<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;
use Illuminate\Validation\ValidationException;

class APITransactionController extends Controller
{
    public function all(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'limit' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:pending,successful,failed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $userId = Auth::user()->id;

        if ($request->has('id')) {
            $transaction = Transaction::with(['item.product'])->find($request->id);

            if ($transaction) {
                return new TransactionResource($transaction);
            }

            return response()->json([
                'pesan' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $query = Transaction::where('user_id', $userId);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $limit = $request->get('limit', 10); // Set default limit if not provided

        $transactions = $query->paginate($limit);

        return new TransactionCollection($transactions);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'exists:products.id',
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELED,FAILED,SHIPPING,SHIPPED',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        foreach ($request->items as $product) {
            $transactionItem = TransactionItem::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product['id'],
                'transaction_id' => $transaction->id,
                'quantity' => $product['quantity'],
            ]);
        }

        // Consider using Laravel's response methods or custom respon
    }
}
