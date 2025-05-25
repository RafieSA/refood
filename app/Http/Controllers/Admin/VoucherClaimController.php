<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherClaimController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $claims = DB::table('discount_claims')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('claim_code', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.voucher-claim-data', compact('claims', 'search'));
    }

    public function destroy($id)
    {
        $claim = DB::table('discount_claims')->where('id', $id)->first();
        if ($claim) {
            DB::table('discount_claims')->where('id', $id)->delete();
            return redirect()->route('admin.voucher.claims.index')->with('success', 'Data klaim berhasil dihapus.');
        }
        return redirect()->route('admin.voucher.claims.index')->with('error', 'Data klaim tidak ditemukan.');
    }
}