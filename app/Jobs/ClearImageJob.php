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
    /**
     * [all items]
     *
     * @var items
     */
    private ?Collection $items = null;

    /**
     * [images in items]
     *
     * @var images
     */
    private array $images;

    /**
     * [images in items]
     *
     * @var images_final
     */
    private array $images_final;

    /**
     * [date for remove images]
     *
     * @var future
     */
    private Carbon $future;

    /**
     * [tries for job]
     *
     * @var tries
     */
    public $tries = 10;

    /**
     * [max exceptions for job]
     *
     * @var maxExceptions
     */
    public $maxExceptions = 2;

    /**
     * [timeout for job]
     *
     * @var timeout
     */
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
            $this->future = Carbon::now()->addMonth();
            $this->items = Help::where('calendar_final', '>', $this->future)
                ->whereNotNull('images')
                ->orWhereNotNull('images_final')
                ->orderBy('id', 'DESC')
                ->get();
            if ($this->items !== null) {
                foreach ($this->items as $item) {
                    if ($item->images !== null) {
                        $this->images = json_decode((string) $item->images, true, 512, JSON_THROW_ON_ERROR);
                        foreach ($this->images as $image) {
                            Storage::disk('images')->delete($image['url']);
                        }
                        $item->forceFill([
                            'images' => null,
                        ])->save();
                    }
                    if ($item->images_final !== null) {
                        $this->images_final = json_decode((string) $item->images_final, true, 512, JSON_THROW_ON_ERROR);
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
