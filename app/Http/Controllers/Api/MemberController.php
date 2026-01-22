<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Period;
use App\Models\PeriodUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function member(Request $request, $slug = null)
    {
        $q = $request->q;
        try {
            $data = PeriodUser::with('user', 'memberField', 'period')
                ->where('role', 'Anggota')
                ->when($q, function ($query) use ($q) {
                    $query->whereHas('user', function ($qUser) use ($q) {
                        $qUser->where('name', 'like', '%' . $q . '%')
                            ->orWhere('nim', 'like', '%' . $q . '%');
                    });
                })
                ->when($slug, function ($query) use ($slug) {
                    $query->whereHas('period', function ($q) use ($slug) {
                        $q->where('slug', $slug);
                    });
                }, function ($query) {
                    $query->whereHas('period', function ($q) {
                        $q->where('end_date', '>=', now());
                    });
                })
                ->get();

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Data anggota berhasil diambil',
                'data' => MemberResource::collection($data)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data anggota: ' . $th->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function committee(Request $request, $slug = null)
    {
        $q = $request->q;
        try {
            $data = PeriodUser::with('user', 'memberField', 'period')
                ->where('role', '!=', 'Anggota')
                ->when($q, function ($query) use ($q) {
                    $query->whereHas('user', function ($qUser) use ($q) {
                        $qUser->where('name', 'like', '%' . $q . '%')
                            ->orWhere('nim', 'like', '%' . $q . '%');
                    });
                })
                ->when($slug, function ($query) use ($slug) {
                    $query->whereHas('period', function ($q) use ($slug) {
                        $q->where('slug', $slug);
                    });
                }, function ($query) {
                    $query->whereHas('period', function ($q) {
                        $q->where('end_date', '>=', now());
                    });
                })
                ->get();

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Data pengurus berhasil diambil',
                'data' => MemberResource::collection($data)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengurus: ' . $th->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function Alumni(Request $request)
    {
        $q = $request->q;
        try {
            // Get periode yang sudah berakhir
            $expiredPeriodIds = Period::where('end_date', '<', Carbon::today())->pluck('id');

            $data = PeriodUser::with('user', 'memberField', 'period')
                ->whereIn('period_id', $expiredPeriodIds)->pluck('user_id')->unique()
                ->when($q, function ($query) use ($q) {
                    $query->whereHas('user', function ($qUser) use ($q) {
                        $qUser->where('name', 'like', '%' . $q . '%')
                            ->orWhere('nim', 'like', '%' . $q . '%');
                    });
                })
                ->get();

            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Data pengurus berhasil diambil',
                'data' => MemberResource::collection($data)
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengurus: ' . $th->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function periods()
    {
        try {
            $periods = Period::get("id", "name", "slug");
            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Periode retrieved successfully',
                'data' => $periods
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
