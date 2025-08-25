<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ClientProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        return view('client.pages.profile.index', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = time() . '_' . ($user->id ?? 'user') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('userfiles/images/avatar'), $filename);
            $userData['avatar'] = '/userfiles/images/avatar/' . $filename;
        }

        $user->update($userData);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(): View
    {
        $user = Auth::user();
        return view('client.pages.profile.change-password', compact('user'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $validated = $validator->validated();

        if (!Hash::check($validated['old_password'], $user->password)) {
            return back()->with('error', 'Mật khẩu cũ không chính xác.');
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function bookingHistory(Request $request): View|JsonResponse
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with(['tour', 'payment'])
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            $html = view('client.pages.profile.partials._booking_history_items', compact('orders'))->render();
            return response()->json([
                'html' => $html,
                'next_page_url' => $orders->hasMorePages() ? $orders->nextPageUrl() : null,
            ]);
        }

        return view('client.pages.profile.history', compact('user', 'orders'));
    }

    public function cancelOrder(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'PENDING' || optional($order->payment)->status === 'SUCCESS') {
            return back()->with('error', 'Đơn hàng này không thể hủy.');
        }

        $validated = $request->validate([
            'reason_option' => 'required|string',
            'reason_other' => 'nullable|required_if:reason_option,other|string|max:1000',
        ], [
            'reason_option.required' => 'Vui lòng chọn một lý do hủy.',
            'reason_other.required_if' => 'Vui lòng nhập lý do cụ thể của bạn.'
        ]);

        $cancellationReason = $validated['reason_option'];
        if ($cancellationReason === 'other') {
            $cancellationReason = $validated['reason_other'];
        }

        $order->update([
            'status' => 'CANCELLED',
            'cancellation_reason' => $cancellationReason,
        ]);

        if ($order->payment) {
            $order->payment->update(['status' => 'CANCELLED']);
        }

        return back()->with('success', 'Đã hủy đơn hàng thành công.');
    }

    public function sendVerificationEmail(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return back()->with('info', 'Email của bạn đã được xác minh từ trước.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.');
    }
}
