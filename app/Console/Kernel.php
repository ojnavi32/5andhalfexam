<?php

namespace App\Console;

use App\Pet;
use App\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $orders = Order::all();
            
            foreach ($orders as $order) {
                if (strtotime($order->shipDate) < strtotime('now')) {
                    $pet = Pet::findOrFail($order->petId);
                    $pet->status = 'available';
                    $pet->save();
                    
                    $order->status = 'delivered';
                    $order->save();
                    
                }
            }
        })->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
