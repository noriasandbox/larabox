<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('proposed_budget')
                    ->required(),
                Forms\Components\TextInput::make('actual_budget'),
                Forms\Components\DatePicker::make('proposed_start_date')
                    ->required(),
                Forms\Components\DatePicker::make('actual_start_date'),
                Forms\Components\DatePicker::make('proposed_end_date')
                    ->required(),
                Forms\Components\DatePicker::make('actual_end_date'),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(1000),
                Forms\Components\TextInput::make('project_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('meta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('proposed_budget'),
                Tables\Columns\TextColumn::make('actual_budget'),
                Tables\Columns\TextColumn::make('proposed_start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('actual_start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('proposed_end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('actual_end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('project_id'),
                Tables\Columns\TextColumn::make('author_id'),
                Tables\Columns\TextColumn::make('meta'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTasks::route('/'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
