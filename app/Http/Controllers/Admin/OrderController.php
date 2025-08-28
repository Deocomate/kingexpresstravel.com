<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'tour']);

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhereHas('tour', fn($subQuery) => $subQuery->where('name', 'like', '%' . $search . '%'));
            });
        });

        $request->whenFilled('status', function ($status) use ($query) {
            $query->where('status', $status);
        });

        $request->whenFilled('date_range', function ($dateRange) use ($query) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (Exception) {
                }
            }
        });

        $orders = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.modules.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'tour']);
        return view('admin.modules.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'])],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
    }

    public function showPayment(Order $order): View
    {
        $order->load('payment', 'user', 'tour');
        return view('admin.modules.orders.payment', compact('order'));
    }

    public function updatePayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['PENDING', 'SUCCESS', 'FAILED', 'CANCELLED', 'REFUNDED'])],
            'note' => ['nullable', 'string', 'max:2000'],
            'transaction_id' => ['nullable', 'string', 'max:2000'],
        ]);

        $payment = $order->payment()->firstOrCreate(
            ['order_id' => $order->id],
            ['amount' => $order->total_price, 'method' => 'Chưa xác định']
        );

        $paymentData = [
            'status' => $validated['status'],
            'note' => $validated['note'],
            'transaction_id' => $validated['transaction_id'],
        ];

        if ($validated['status'] === 'SUCCESS' && $payment->status !== 'SUCCESS') {
            $paymentData['paid_at'] = now();
        }

        $payment->update($paymentData);

        return back()->with('success', 'Cập nhật thông tin thanh toán thành công.');
    }
}
