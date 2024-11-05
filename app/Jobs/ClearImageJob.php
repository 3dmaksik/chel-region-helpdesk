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
        if (config('settings.clearFile') > 0) {
            $this->items = Help::where('files_remove', '<', Carbon::now())
                ->WhereNotNull('calendar_final')
                ->orderBy('id', 'DESC')
                ->get();
            foreach ($this->items as $item) {
                foreach ($item->images as $image) {
                    Storage::disk('images')->delete($image['url']);
                }
                foreach ($item->files as $file) {
                    Storage::disk('file')->delete($file['url']);
                }

                $item->forceFill([
                    'images' => null,
                    'files' => null,
                    'files_remove' => null,
                ])->save();
            }
            $this->items = Help::where('files_final_remove', '<', Carbon::now())
                ->WhereNotNull('calendar_final')
                ->orderBy('id', 'DESC')
                ->get();
            foreach ($this->items as $item) {
                foreach ($item->images as $image) {
                    Storage::disk('images')->delete($image['url']);
                }
                foreach ($item->files as $file) {
                    Storage::disk('file')->delete($file['url']);
                }
                $item->forceFill([
                    'images_final' => null,
                    'files_final' => null,
                    'files_final_remove' => null,
                ])->save();
            }
        }
    }
}
