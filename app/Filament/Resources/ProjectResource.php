<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

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
                Forms\Components\TextInput::make('location')
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
                Tables\Columns\TextColumn::make('location'),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
        ];
    }    
}
