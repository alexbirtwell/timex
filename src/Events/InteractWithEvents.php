<?php

namespace Buildix\Timex\Events;

use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;
use Mikrosmile\FilamentCalendar\Models\Event;
use Mikrosmile\FilamentCalendar\Resources\EventResource;

trait InteractWithEvents
{
    use InteractsWithForms;
    use UsesResourceForm;
    protected static string $resource;
    protected static string $model;
    public $record;

    /**
     * @return string
     */
    public static function getModel(): string
    {
        return static::$model = config('timex.models.event');
    }

    public static function getResource(): string
    {
        return static::$resource = config('timex.resources.event');
    }

    protected function getFormModel(): Model|string|null
    {
        $record = self::getModel()::query()->find($this->record);
        return $record;
    }

    public function eventUpdated($data)
    {
        $event = self::getModel()::query()->find($data['id']);
        $event->update([
            'start' => Carbon::createFromTimestamp($data['toDate'])
        ]);
        $this->emit('modelUpdated',['id' => $this->id]);
        $this->emit('updateWidget',['id' => $this->id]);
    }


}
