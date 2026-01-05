<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $customers = User::where('role', 'user')
            ->whereHas('orders') // Filter only users who have ordered
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('orders') // Assuming User hasMany Order
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Optional: Prevent deleting users with active orders or handle strictly
        // For now, simple delete
        $user->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
