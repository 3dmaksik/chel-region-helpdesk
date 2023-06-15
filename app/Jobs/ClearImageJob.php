<?php

namespace App\Jobs;

use App\Base\Jobs\Job;
use App\Models\Help;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ClearImageJob extends Job implements ShouldQueue
{
    private ?Collection $items;

    private array $images;

    private array $images_final;

    private Carbon $future;

    public $tries = 10;

    public $maxExceptions = 2;

    public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (config('settings.clearImage') > 0) {
            $this->future = Carbon::now()->addMonth(config('settings.clearImage'));
            $this->items = Help::dontCache()->where('calendar_final', '>', $this->future)
                ->whereNotNull('images')
                ->orWhereNotNull('images_final')
                ->orderBy('id', 'DESC')
                ->get();
            if ($this->items !== null) {
                foreach ($this->items as $item) {
                    if ($item->images !== null) {
                        $this->images = json_decode($item->images, true);
                        foreach ($this->images as $image) {
                            Storage::disk('images')->delete($image['url']);
                        }
                        $item->forceFill([
                            'images' => null,
                        ])->save();
                    }
                    if ($item->images_final !== null) {
                        $this->images_final = json_decode($item->images_final, true);
                        foreach ($this->images_final as $image) {
                            Storage::disk('images')->delete($image['url']);
                        }
                        $item->forceFill([
                            'images_final' => null,
                        ])->save();
                    }
                }
            }
        }
    }
}
