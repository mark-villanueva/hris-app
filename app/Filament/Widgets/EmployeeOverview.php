<?php

namespace App\Filament\Widgets;

use App\Models\LeaveRequest;
use App\Models\Schedule;
use App\Models\User;
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
        // Query to count distinct users with a time-in entry for the current day
        return Schedule::whereDate('time_in', now()->toDateString())
            ->distinct('user_id')
            ->count('user_id');
    }

    protected function getTotalAbsents(): int
    {
        // Assuming you have a way to count total users and those with time-in for absentees
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
        // Assuming there's a User model and all users are scheduled each day
        return \App\Models\User::count();
    }
}
