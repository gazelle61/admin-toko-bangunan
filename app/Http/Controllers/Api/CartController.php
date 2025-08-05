<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('barang')
            ->where('users_id', Auth::id())
            ->where('status_cart', 'active')
            ->get();

        $total = $items->sum('total_harga');

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $harga = $barang->harga;
        $qty = $request->quantity;
        $subtotal = $harga * $qty;

        $cartItem = CartItem::where('users_id', Auth::id())
            ->where('barang_id', $barang->id)
            ->where('status_cart', 'active')
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $qty;
            $cartItem->total_harga = $cartItem->quantity * $cartItem->harga_satuan;
            $cartItem->save();
        } else {
            CartItem::create([
                'users_id' => Auth::id(),
                'barang_id' => $barang->id,
                'quantity' => $qty,
                'harga_satuan' => $harga,
                'total_harga' => $subtotal,
            ]);
        }

        return response()->json(['message' => 'Barang ditambahkan ke keranjang']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::where('id', $id)
            ->where('users_id', Auth::id())
            ->where('status_cart', 'active')
            ->firstOrFail();

        $item->quantity = $request->quantity;
        $item->total_harga = $item->harga_satuan * $item->quantity;
        $item->save();

        return response()->json(['message' => 'Jumlah barang diperbarui']);
    }

    public function destroy($id)
    {
        $item = CartItem::where('id', $id)
            ->where('users_id', Auth::id())
            ->where('status_cart', 'active')
            ->firstOrFail();

        $item->delete();

        return response()->json(['message' => 'Barang dihapus dari keranjang']);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string',
            'no_telepon' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'ongkir' => 'nullable|numeric',
        ]);

        $userId = Auth::id();

        $cartitems = CartItem::where('users_id', $userId)
            ->where('status_cart', 'active')
            ->with('barang')
            ->get();

        if ($cartitems->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong.'], 400);
        }

        DB::beginTransaction();
        try {
            $totalBarang = $cartitems->sum('total_harga');
            $totalHarga = $totalBarang + ($request->ongkir ?? 0);

            $transaksi = Transaction::create([
                'users_id' => $userId,
                'nama_penerima' => $request->nama_penerima,
                'no_telepon' => $request->no_telepon,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'ongkir' => $request->ongkir ?? 0,
                'total_harga' => $totalHarga,
                'status_transactions' => 'pending',
                'created_at' => now(),
            ]);

            foreach ($cartitems as $item) {
                TransactionItem::create([
                    'transactions_id' => $transaksi->id,
                    'barang_id' => $item->barang_id,
                    'quantity' => $item->quantity,
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->total_harga,
                ]);

                $item->barang->decrement('stok', $item->quantity);

                $item->status_cart = 'checked_out';
                $item->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Checkout berhasil.',
                'transactions_id' => $transaksi->id,
                'total' => $totalHarga
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Checkout gagal.', 'error' => $e->getMessage()], 500);
        }
    }

    public function riwayatUser()
    {
        $user = auth()->user();

        $transactions = Transaction::with(['items.barang'])
            ->where('users_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($transactions);
    }
}
