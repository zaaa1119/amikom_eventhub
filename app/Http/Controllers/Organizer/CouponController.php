<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('partner_id', auth()->user()->partner_id)
            ->latest()
            ->paginate(10);

        return view('organizer.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('organizer.coupons.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateCoupon($request);
        $data['partner_id'] = auth()->user()->partner_id;

        Coupon::create($data);

        return redirect()->route('organizer.coupons.index')
            ->with('success', 'Kupon berhasil dibuat.');
    }

    public function edit(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);
        return view('organizer.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);

        $data = $this->validateCoupon($request, $coupon->id);
        $coupon->update($data);

        return redirect()->route('organizer.coupons.index')
            ->with('success', 'Kupon berhasil diupdate.');
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorizeOwnership($coupon);
        $coupon->delete();

        return redirect()->route('organizer.coupons.index')
            ->with('success', 'Kupon berhasil dihapus.');
    }

    private function validateCoupon(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code' . ($ignoreId ? ",$ignoreId" : ''),
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|integer|min:1',
            'max_discount' => 'nullable|integer|min:0',
            'min_purchase' => 'nullable|integer|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_until' => 'nullable|date|after_or_equal:today',
        ]);
    }

    private function authorizeOwnership(Coupon $coupon): void
    {
        abort_if($coupon->partner_id !== auth()->user()->partner_id, 403, 'Kupon ini bukan milik kamu.');
    }
}