<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Pages\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentResource;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
    
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
        // return route('filament.pages.dashboard');
        // return route('filament.resources.students.index');
    }

    protected function afterCreate(): void
    {
        $order = $this->record;

        Notification::make()
            ->title('New Student Registered')
            ->icon('heroicon-o-shopping-bag')
            // ->body("**{$order->customer->name} ordered {$order->items->count()} products.**")
            ->actions([
                Action::make('View')
                    ->url(StudentResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase(auth()->user());
    }

}
