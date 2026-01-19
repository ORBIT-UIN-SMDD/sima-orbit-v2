<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\PeriodUser;
use App\Models\SettingWebsite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $setting_web = SettingWebsite::first();

        // Get periode yang sudah berakhir
        $expiredPeriodIds = Period::where('end_date', '<', Carbon::today())->pluck('id');

        // Get user yang pernah terdaftar di periode yang sudah berakhir
        $alumniUserIds = PeriodUser::whereIn('period_id', $expiredPeriodIds)->pluck('user_id')->unique();

        // Get alumni users dengan lokasi
        $alumni = User::whereIn('id', $alumniUserIds)
            ->with(['department.faculty'])
            ->get();

        // Prepare data untuk map (alumni yang punya koordinat)
        $alumniForMap = $alumni->filter(function($user) {
            return $user->latitude && $user->longitude;
        })->map(function($user) use ($expiredPeriodIds) {
            // Get all periods for this alumni
            $allPeriods = PeriodUser::where('user_id', $user->id)
                ->whereIn('period_id', $expiredPeriodIds)
                ->with(['period', 'memberField'])
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($pu) {
                    return [
                        'period_id' => $pu->period_id,
                        'period_name' => $pu->period->name ?? '-',
                        'role' => $pu->role ?? '-',
                        'member_field' => $pu->memberField->name ?? '-',
                    ];
                });

            $lastPeriod = $allPeriods->first();

            return [
                'id' => $user->id,
                'name' => $user->name,
                'photo' => $user->getPhoto(),
                'gender' => $user->gender ?? '-',
                'job' => $user->job ?? '-',
                'bio' => $user->bio ?? '-',
                'period_id' => $lastPeriod ? $lastPeriod['period_id'] : null,
                'periods' => $allPeriods->toArray(),
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
            ];
        })->values();

        // Get expired periods for filter
        $expiredPeriods = Period::where('end_date', '<', Carbon::today())
            ->orderBy('end_date', 'desc')
            ->get(['id', 'name']);

        $data = [
            'title' => 'Persebaran Alumni',
            'meta' => [
                'title' => 'Alumni | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Alumni ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Alumni',
                    'link' => route('alumni.index')
                ]
            ],
            'setting_web' => $setting_web,
            'alumni' => $alumni,
            'alumniForMap' => $alumniForMap,
            'periods' => $expiredPeriods,
            'totalAlumni' => $alumni->count(),
            'alumniWithLocation' => $alumniForMap->count(),
        ];
        return view('front.pages.alumni.index', $data);
    }
}
