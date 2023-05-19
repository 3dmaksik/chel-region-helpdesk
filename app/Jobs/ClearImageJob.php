<?php

namespace App\Jobs;

use App\Base\Jobs\Job;
use App\Models\Help as Model;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ClearImageJob extends Job implements ShouldQueue
{
    private ?Model $item;

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
        $this->future = Carbon::now()->addMonth(config('settings.clearImage'));
        $this->item = Model::dontCache()->where('calendar_final', '>', $this->future)
            ->whereNotNull('images')
            ->orWhereNotNull('images_final')
            ->orderBy('id', 'DESC')
            ->first();
        if ($this->item !== null) {
            if ($this->item->images !== null) {
                $this->images = json_decode($this->item->images, true);
                foreach ($this->images as $image) {
                    Storage::disk('images')->delete($image['url']);
                }
                $this->item->forceFill([
                    'images' => null,
                ])->save();
            }
            if ($this->item->images_final !== null) {
                $this->images_final = json_decode($this->item->images_final, true);
                foreach ($this->images_final as $image) {
                    Storage::disk('images')->delete($image['url']);
                }
                $this->item->forceFill([
                    'images_final' => null,
                ])->save();
            }
        }

        //
    }
}
