<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {


        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('student_id')
                            ->label('Student ID')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('address_1')
                            ->label('Address-1')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('address_2')
                            ->label('Address-2')
                            ->maxLength(255)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?Student $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (Student $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (Student $record): ?string => $record->updated_at?->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Student $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->tooltip(fn($record): string => $record->name)
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('student_id')
                    ->label('Student ID')
                    ->searchable()
                    ->tooltip(fn($record): string => $record->student_id)
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('address_1')
                    ->label('Address-1')
                    ->searchable()
                    ->tooltip(fn($record): string => $record->address_1)
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('address_2')
                    ->label('Address-2')
                    ->searchable()
                    ->tooltip(fn($record): string => $record->address_2)
                    ->toggleable(isToggledHiddenByDefault:false)
                    ->limit(50)
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }   
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'address_1'];
    }
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
}
