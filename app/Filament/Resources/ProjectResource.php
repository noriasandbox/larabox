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
                Forms\Components\Builder\Block::make('Permissions')
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
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->money(prefix: 'KES ', thousandsSeparator: ',', decimalPlaces: 0))
                            ->required(),
                        Forms\Components\TextInput::make('actual_budget'),
                        Forms\Components\DatePicker::make('proposed_start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('actual_start_date'),
                        Forms\Components\DatePicker::make('proposed_end_date')
                            ->required(),
                        Forms\Components\DatePicker::make('actual_end_date'),
                    ])->columns(2),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(1000)

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('location'),
                Tables\Columns\TextColumn::make('proposed_budget')->money('KES', ',', 0),
                Tables\Columns\TextColumn::make('proposed_start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('proposed_end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author'),
                Tables\Columns\TextColumn::make('meta'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('jS M Y, g:i: A'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('jS M Y, g:i: A'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
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
            'index' => Pages\ManageProjects::route('/'),
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
