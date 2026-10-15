<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Produk;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    // ==========================================
    // FRONTEND: KERANJANG & CHECKOUT
    // ==========================================

    public function addToCart($id)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        if (!$customer) return redirect()->back()->with('error', 'Lengkapi profil Anda.');

        $produk = Produk::findOrFail($id);
        if ($produk->stok < 1) return redirect()->back()->with('error', 'Stok habis.');

        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => 'pending'],
            ['total_harga' => 0]
        );

        $orderItem = OrderItem::firstOrCreate(
            ['order_id' => $order->id, 'produk_id' => $produk->id],
            ['quantity' => 0, 'harga' => $produk->harga]
        );

        if ($orderItem->quantity + 1 > $produk->stok) return redirect()->back()->with('error', 'Stok tidak cukup.');

        $orderItem->increment('quantity');
        $order->increment('total_harga', $produk->harga);

        return redirect()->route('order.cart')->with('success', 'Berhasil ditambah ke keranjang');
    }

    public function viewCart()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer?->id)->where('status', 'pending')->first();
        if ($order) $order->load('orderItems.produk');
        return view('v_order.cart', compact('order'));
    }

    public function complete()
    {
        // Ambil data customer berdasarkan user yang sedang login
        $customer = Customer::where('user_id', Auth::id())->first();

        if (!$customer) {
            return redirect()->route('order.cart')
                ->with('error', 'Data customer tidak ditemukan.');
        }

        // Cari order yang masih pending
        $order = Order::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('order.cart')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Kurangi stok produk
        foreach ($order->orderItems as $item) {
            $produk = Produk::find($item->produk_id);
            if ($produk) {
                $produk->stok -= $item->quantity;
                $produk->save();
            }
        }

        // Update order
        $order->status = 'Paid';
        $order->save();

        return redirect()->route('order.history')
            ->with('success', 'Checkout berhasil.');
    }

    public function orderHistory()
{
    $customer = Customer::where('user_id', Auth::id())->first();

    $orders = Order::where('customer_id', $customer->id)
        ->whereIn('status', ['proses', 'Paid', 'Kirim', 'Selesai', 'gagal'])
        ->orderBy('id', 'desc')
        ->get();

    return view('v_order.history', ['orders' => $orders]);
}

    // ==========================================
    // BACKEND: ADMIN
    // ==========================================

    public function statusProses()
    {
        $order = Order::with('customer')
                      ->whereIn('status', ['proses', 'Paid', 'Kirim'])
                      ->orderBy('id', 'desc')
                      ->get();

        return view('backend.v_pesanan.proses', [
            'judul' => 'Pesanan',
            'subJudul' => 'Pesanan Proses',
            'index' => $order
        ]);
    }

    public function statusSelesai()
    {
        $order = Order::where('status', 'Selesai')->orderBy('id', 'desc')->get();
        return view('backend.v_pesanan.selesai', [
            'judul' => 'Pesanan Selesai',
            'subJudul' => 'Data Transaksi Selesai',
            'index' => $order
        ]);
    }

    public function statusDetail($id)
    {
        $order = Order::with(['customer.user', 'orderItems.produk'])->findOrFail($id);
        return view('backend.v_pesanan.detail', [
            'judul' => 'Detail Pesanan',
            'subJudul' => 'Rincian Transaksi',
            'order' => $order,
        ]);
    }

    public function statusUpdate(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        if ($request->status == 'Selesai') {
            return redirect()->route('backend.pesanan.selesai')->with('success', 'Selesai');
        }
        return redirect()->route('backend.pesanan.proses')->with('success', 'Updated');
    }

    public function updateongkir(Request $request)
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $order = Order::where('customer_id', $customer->id)->where('status', 'pending')->first();

        if ($order) {
            $order->update([
                'kurir' => $request->kurir,
                'layanan_ongkir' => $request->layanan_ongkir,
                'biaya_ongkir' => $request->biaya_ongkir,
                'estimasi_ongkir' => $request->estimasi_ongkir,
                'total_berat' => $request->total_berat,
                'alamat' => $request->alamat . ', ' . $request->city_name . ', ' . $request->province_name,
                'pos' => $request->pos ?? '-'
            ]);

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
    }

    public function removeFromCart($id)
    {
        $customer_id = auth()->user()->customer->id;
        $order = Order::where('customer_id', $customer_id)->where('status', 'pending')->first();

        if ($order) {
            $order->orderItems()->where('produk_id', $id)->delete();
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus produk.');
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $orderItem = OrderItem::findOrFail($id);

        if ($request->quantity > $orderItem->produk->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $orderItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function cart()
    {
        $order = Order::where('customer_id', auth()->user()->customer->id)
                      ->where('status', 'pending')
                      ->first();
        return view('v_order.cart', compact('order'));
    }

    public function select_shipping()
{
    $user = auth()->user();

    if (!$user->customer) {
        return redirect()->route('customer.akun')->with('error', 'Silakan lengkapi profil Anda terlebih dahulu.');
    }

    $order = Order::where('customer_id', $user->customer->id)
                  ->where('status', 'pending')
                  ->first();

    if (!$order || $order->orderItems->count() == 0) {
        return redirect()->route('order.cart')->with('error', 'Keranjang Anda kosong. Silakan belanja dulu!');
    }

    $totalBerat = $order->orderItems->sum(function ($item) {
        return ($item->produk->berat ?? 0) * $item->quantity;
    });

    // Tambahkan baris ini untuk menghitung jumlah item di keranjang belanja (Badge Navbar)
    $cartCount = $order; 

    // Masukkan 'cartCount' ke dalam fungsi compact()
    return view('v_order.select_shipping', compact('order', 'totalBerat', 'cartCount'));
}

 public function formpesanan()
    {
        $judul = 'Laporan Data Pesanan';
        return view('backend.v_pesanan.form', compact('judul'));
    }

    public function cetakPesanan(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $pesanan = Order::with('customer')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.v_pesanan.cetak', [
            'judul' => 'Laporan Pesanan',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $pesanan
        ]);
    }

    public function invoiceBackend($id)
    {
        $order = Order::with('customer', 'orderItems.produk')->findOrFail($id);
        return view('backend.v_pesanan.invoice', compact('order'));
    }


    public function select_payment()
    {
        $order = Order::where('customer_id', auth()->user()->customer->id)
                      ->where('status', 'pending')
                      ->first();

        if (!$order || $order->biaya_ongkir == 0) {
            return redirect()->route('order.select_shipping')
                             ->with('error', 'Pilih pengiriman terlebih dahulu!');
        }

        $subtotal = 0;
        foreach ($order->orderItems as $item) {
            $subtotal += $item->harga * $item->quantity;
        }

        $totalBayar = $subtotal + $order->biaya_ongkir;

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->nama,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
                'finish' => route('order.complete'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            session(['paying_order_id' => $order->id]); // simpan order id ke session

            return view('v_order.select_payment', compact(
                'order',
                'snapToken',
                'subtotal',
                'totalBayar'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function midtransCallback(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $data = $request->all();

            $transactionStatus = $data['transaction_status'] ?? null;
            $orderId = $data['order_id'] ?? null;
            $fraudStatus = $data['fraud_status'] ?? 'accept';

            if (!$orderId) {
                return response()->json(['message' => 'Order ID tidak ada'], 400);
            }

            $orderIdParts = explode('-', $orderId);
            $realOrderId = $orderIdParts[0];

            $order = Order::find($realOrderId);

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            if ($transactionStatus == 'settlement' ||
                ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                $order->status = 'proses';
                $order->save();
            } elseif ($transactionStatus == 'pending') {
                $order->status = 'pending';
                $order->save();
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->status = 'gagal';
                $order->save();
            }

            return response()->json(['message' => 'Callback diproses', 'status' => $order->status]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function invoice($id)
    {
        $order = Order::with('customer', 'orderItems.produk')->findOrFail($id);
        return view('v_order.invoice', compact('order'));
    }
}