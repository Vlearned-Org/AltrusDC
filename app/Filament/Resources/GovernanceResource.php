<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovernanceResource\Pages;
use App\Filament\Resources\GovernanceResource\RelationManagers;
use App\Models\Governance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GovernanceResource extends Resource
{
    protected static ?string $model = Governance::class;

   
protected static ?string $navigationGroup = 'ESG Data';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fiscal_year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('anti_corruption_pic')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('management_trained_pct')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('executive_trained_pct')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('non_executive_trained_pct')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('general_workers_trained_pct')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('operations_assessed_pct')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('corruption_incidents_count')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('human_rights_pic')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('human_rights_complaints')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('data_privacy_pic')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('data_privacy_breaches')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('whistleblowing_pic')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('whistleblowing_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('whistleblowing_address')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fiscal_year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anti_corruption_pic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('management_trained_pct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('executive_trained_pct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('non_executive_trained_pct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('general_workers_trained_pct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('operations_assessed_pct')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('corruption_incidents_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('human_rights_pic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('human_rights_complaints')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_privacy_pic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_privacy_breaches')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('whistleblowing_pic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whistleblowing_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whistleblowing_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGovernances::route('/'),
        ];
    }
}
