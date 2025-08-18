<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCare;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CustomerCareController extends Controller
{
    public function index(Request $request): View
    {
        $query = CustomerCare::query();

        $request->whenFilled('search', function ($search) use ($query) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('subject', 'like', '%' . $search . '%');
            });
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

        $contacts = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return view('admin.modules.customer-care.index', compact('contacts'));
    }

    public function show(CustomerCare $customerCare): View
    {
        return view('admin.modules.customer-care.show', compact('customerCare'));
    }

    public function destroy(CustomerCare $customerCare): RedirectResponse
    {
        $customerCare->delete();
        return redirect()->route('admin.customer-care.index')->with('success', 'Xóa liên hệ thành công.');
    }
}
