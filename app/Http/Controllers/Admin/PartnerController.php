<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::with('organizerAccount');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $partners = $query->latest()->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'organizer_email' => 'nullable|required_if:create_login,1|email|unique:users,email',
            'organizer_password' => 'nullable|required_if:create_login,1|min:8|confirmed',
        ]);

        $path = $request->file('logo')->store('partners', 'public');

        $partner = Partner::create([
            'name' => $request->name,
            'logo_url' => $path,
        ]);

        if ($request->boolean('create_login')) {
            try {
                $this->createOrganizerAccount($partner, $request);
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->withErrors(['organizer_email' => 'Partner ini sudah punya akun, tidak bisa dibuat lagi.']);
            }
        }

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $partner = Partner::with('organizerAccount')->findOrFail($id);

        $eventIds = $partner->events()->pluck('id');

        $totalEvent = $eventIds->count();
        $totalTiketTerjual = \App\Models\Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->count();
        $totalPendapatan = \App\Models\Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['settlement', 'success'])
            ->sum('total_price');
        $totalPendapatanShort = $this->formatRupiahSingkat($totalPendapatan);
        $avgRating = \App\Models\Review::whereIn('event_id', $eventIds)->avg('rating');
        $reviewCount = \App\Models\Review::whereIn('event_id', $eventIds)->count();

        $events = $partner->events()
            ->withCount(['reviews'])
            ->withCount(['transactions as tiket_terjual' => function ($query) {
                $query->whereIn('status', ['settlement', 'success']);
            }])
            ->latest()
            ->get();

        return view('admin.partners.show', compact(
            'partner',
            'totalEvent',
            'totalTiketTerjual',
            'totalPendapatan',
            'totalPendapatanShort',
            'avgRating',
            'reviewCount',
            'events'
        ));
    }

    public function edit(string $id)
    {
        $partner = Partner::with('organizerAccount')->findOrFail($id);

        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, string $id)
    {
        $partner = Partner::findOrFail($id);
        $hasOrganizer = $partner->organizerAccount()->exists();

        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'organizer_email' => 'nullable|required_if:create_login,1|email|unique:users,email',
            'organizer_password' => 'nullable|required_if:create_login,1|min:8|confirmed',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('logo')) {
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }
            $data['logo_url'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        if (! $hasOrganizer && $request->boolean('create_login')) {
            try {
                $this->createOrganizerAccount($partner, $request);
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->withErrors(['organizer_email' => 'Partner ini sudah punya akun, tidak bisa dibuat lagi.']);
            }
        }

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil diupdate');
    }

    private function createOrganizerAccount(Partner $partner, Request $request): void
    {
        $organizer = new User([
            'name' => $partner->name,
            'email' => $request->organizer_email,
            'partner_id' => $partner->id,
        ]);
        $organizer->password = Hash::make($request->organizer_password);
        $organizer->role = 'organizer';
        $organizer->email_verified_at = now();
        $organizer->save();
    }

    private function formatRupiahSingkat($number)
    {
        if ($number >= 1_000_000_000) return 'Rp' . number_format($number / 1_000_000_000, 1) . ' M';
        if ($number >= 1_000_000) return 'Rp' . number_format($number / 1_000_000, 1) . ' Jt';
        return 'Rp' . number_format($number, 0, ',', '.');
    }

    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner berhasil dihapus');
    }

    
}
