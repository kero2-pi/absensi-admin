protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
{
    // Generate kehadiran setiap weekday jam 06:00
    $schedule->command('kehadiran:generate')
             ->weekdays()
             ->dailyAt('00:05');
}
