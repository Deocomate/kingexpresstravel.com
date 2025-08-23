<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientCheckoutController extends Controller
{
    public function index(Tour $tour): View
    {
        $user = Auth::user();
        $tour->load('destinations');
        return view('client.pages.checkout.index', compact('tour', 'user'));
    }

    public function store(Request $request, Tour $tour): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:1000',
            'departure_date' => 'required|date|after_or_equal:today',
            'adult_quantity' => 'required|integer|min:1',
            'child_quantity' => 'required|integer|min:0',
            'toddler_quantity' => 'required|integer|min:0',
            'infant_quantity' => 'required|integer|min:0',
            'note' => 'nullable|string',
            'payment_method' => ['required', Rule::in(['office', 'vnpay'])],
        ]);

        if (($validated['adult_quantity'] + $validated['child_quantity']) > ($tour->remaining_slots ?? 999)) {
            return back()->withInput()->with('error', 'Số lượng khách vượt quá số chỗ còn lại của tour.');
        }

        $totalPrice = ($validated['adult_quantity'] * ($tour->price_adult ?? 0))
            + ($validated['child_quantity'] * ($tour->price_child ?? 0))
            + ($validated['toddler_quantity'] * ($tour->price_toddler ?? 0))
            + ($validated['infant_quantity'] * ($tour->price_infant ?? 0));

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'tour_id' => $tour->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'departure_date' => $validated['departure_date'],
                'adult_quantity' => $validated['adult_quantity'],
                'child_quantity' => $validated['child_quantity'],
                'toddler_quantity' => $validated['toddler_quantity'],
                'infant_quantity' => $validated['infant_quantity'],
                'total_price' => $totalPrice,
                'note' => $validated['note'],
                'status' => 'PENDING',
            ]);

            if ($validated['payment_method'] === 'office') {
                Payment::create([
                    'order_id' => $order->id,
                    'method' => 'Thanh toán tại văn phòng',
                    'amount' => $totalPrice,
                    'status' => 'PENDING',
                ]);
                DB::commit();
                return redirect()->route('client.home')->with('success', 'Đặt tour thành công! Vui lòng đến văn phòng để hoàn tất thanh toán.');
            }

            if ($validated['payment_method'] === 'vnpay') {
                Payment::create([
                    'order_id' => $order->id,
                    'method' => 'VNPAY',
                    'amount' => $totalPrice,
                    'status' => 'PENDING',
                ]);
                DB::commit();
                return redirect()->route('client.home')->with('success', 'Đặt tour thành công! Chức năng thanh toán VNPAY đang được phát triển.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Đã có lỗi xảy ra trong quá trình đặt tour. Vui lòng thử lại.');
        }

        return redirect()->route('client.home');
    }
}
