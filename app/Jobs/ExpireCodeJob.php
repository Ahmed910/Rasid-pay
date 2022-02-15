<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user, $code_col;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$code_col)
    {
        $this->user = $user;
        $this->code_col = $code_col;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $code = generate_unique_code('\\App\\Models\\User', $this->code_col , 4);
        $this->user->update([$this->code_col => $code]);
    }
}
