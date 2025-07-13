<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubsidiaryResource\Pages;
use App\Filament\Resources\SubsidiaryResource\RelationManagers;
use App\Models\Subsidiary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubsidiaryResource extends Resource
{
    protected static ?string $model = Subsidiary::class;
    protected static ?string $navigationGroup = 'Company Management';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Subsidiaries';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subsidiary Information')
                    ->description('Add or update subsidiary details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'name')
                            ->required()
                            ->label('Parent Company')
                            ->searchable()
                            ->preload()
                            ->helperText('Select the parent company for this subsidiary'),
                            
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Subsidiary Name')
                            ->helperText('Enter the legal name of the subsidiary'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Parent Company')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Subsidiary Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name')
                    ->label('Filter by Parent Company'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Subsidiary'),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubsidiaries::route('/'),
        ];
    }
    
    public static function getRelations(): array
    {
        return [
            //RelationManagers\EmployeesRelationManager::class,
        ];
    }
}