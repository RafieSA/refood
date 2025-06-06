<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function updateStatus(Request $request, $id)
    {
        // Validasi input - hanya 'pending' dan 'used' yang valid sesuai constraint database
        $request->validate([
            'status' => 'required|in:pending,used'
        ]);

        try {
            // Cek apakah claim exists
            $claim = DB::table('discount_claims')->where('id', $id)->first();
            
            if (!$claim) {
                return redirect()->route('admin.voucher.claims.index')->with('error', 'Data klaim tidak ditemukan.');
            }

            // Cek apakah status berubah
            if ($claim->status === $request->status) {
                return redirect()->route('admin.voucher.claims.index')->with('error', 'Status sudah sama, tidak ada perubahan.');
            }

            // Update status
            $updated = DB::table('discount_claims')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            if ($updated) {
                $statusText = $request->status === 'pending' ? 'Belum Diambil' : 'Sudah Diambil';
                return redirect()->route('admin.voucher.claims.index')->with('success', "Status klaim berhasil diubah menjadi: {$statusText}");
            } else {
                return redirect()->route('admin.voucher.claims.index')->with('error', 'Gagal mengupdate status klaim.');
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.voucher.claims.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}