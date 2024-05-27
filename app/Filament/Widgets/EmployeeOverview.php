<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Salary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class EmployeeOverview extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Presents', $this->getTotalPresents()), 
            Stat::make('Absents', $this->getTotalAbsents()), 
            Stat::make('Lates', $this->getTotalLates()),
            Stat::make('On Leave', $this->getTotalApprovedLeaveRequests())
        ];
    }

    protected function getTotalPresents(): int
    {
        return Schedule::whereDate('time_in', now()->toDateString())
            ->distinct('user_id')
            ->count('user_id');
    }

    protected function getTotalAbsents(): int
    {
        $totalUsers = $this->getTotalUsers();
        $totalPresents = $this->getTotalPresents();
        return $totalUsers - $totalPresents;
    }

    protected function getTotalLates(): int
    {
        return Schedule::where(function ($query) {
                    $query->whereRaw('TIME(time_in) > TIME(start_shift)')
                          ->whereRaw('DATE(time_in) = DATE(start_date)');
                })
                ->count();
    }

    protected function getTotalApprovedLeaveRequests(): int
    {
        return LeaveRequest::where('status', 'approved')->count();
    }

    protected function getTotalUsers(): int
    {
        return User::count();
    }

    public static function getUserPresentDays(): array
    {
        return Schedule::select('user_id', DB::raw('COUNT(DISTINCT DATE(time_in)) as days_present'))
            ->groupBy('user_id')
            ->get()
            ->pluck('days_present', 'user_id')
            ->toArray();
    }
    
    public static function getTotalRegularHours(): array
    {
        return Schedule::select('user_id', DB::raw('ROUND(SUM(TIME_TO_SEC(TIMEDIFF(time_out, time_in)) / 3600), 2) as total_hours'))
            ->groupBy('user_id')
            ->get()
            ->pluck('total_hours', 'user_id')
            ->toArray();
    }    

    public static function getTotalOvertimeHours(): array
    {
        return Schedule::select('user_id', DB::raw('ROUND(SUM(TIME_TO_SEC(TIMEDIFF(TIME(time_out), end_shift)) / 3600), 2) as total_overtime_hours'))
            ->whereRaw('TIME(time_out) > end_shift')
            ->groupBy('user_id')
            ->get()
            ->pluck('total_overtime_hours', 'user_id')
            ->toArray();
    }
    
}
