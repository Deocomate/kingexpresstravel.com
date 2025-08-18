<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactBranch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function edit(): View
    {
        $contact = Contact::with('branches')->firstOrCreate();
        return view('admin.modules.contact.edit', compact('contact'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'facebook' => 'nullable|string|max:255',
            'zalo' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:255',
            'branches' => 'nullable|array',
            'branches.*.id' => 'nullable|integer|exists:contact_branches,id',
            'branches.*.branch_name' => 'required|string|max:255',
            'branches.*.address' => 'nullable|string|max:255',
            'branches.*.phone' => 'nullable|string|max:20',
            'branches.*.email' => 'nullable|email|max:255',
            'branches.*.working_hours' => 'nullable|string|max:255',
            'is_main_branch' => 'nullable|integer',
        ]);

        $contact = Contact::firstOrCreate([]);
        $contact->update(Arr::except($validated, ['branches', 'is_main_branch']));

        $mainBranchIndex = $request->input('is_main_branch');
        $keptBranchIds = [];

        if (!empty($validated['branches'])) {
            foreach ($validated['branches'] as $index => $branchData) {
                $branchData['is_main'] = ($index == $mainBranchIndex);

                $branch = ContactBranch::updateOrCreate(
                    ['id' => $branchData['id'] ?? null, 'contact_id' => $contact->id],
                    Arr::except($branchData, 'id')
                );
                $keptBranchIds[] = $branch->id;
            }
        }

        $contact->branches()->whereNotIn('id', $keptBranchIds)->delete();

        return redirect()->route('admin.contacts.edit')->with('success', 'Cập nhật thông tin liên hệ thành công.');
    }
}
