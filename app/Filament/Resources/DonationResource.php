<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $modelLabel = 'Donation';
    protected static ?string $pluralModelLabel = 'Donations';
    protected static ?string $navigationLabel = 'Donations';
     protected static ?string $navigationGroup = 'Organization';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Donation Information')
                    ->schema([
                        Forms\Components\TextInput::make('donor_name')
                            ->label('Donor Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('John Doe')
                            ->helperText('Full name of the individual or organization making the donation'),
                            
                        Forms\Components\TextInput::make('organization_name')
                            ->label('Organization (if applicable)')
                            ->maxLength(255)
                            ->placeholder('Acme Corporation')
                            ->helperText('Name of the organization if donation is from a company'),
                            
                        Forms\Components\TextInput::make('pic_name')
                            ->label('Point of Contact')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Jane Smith')
                            ->helperText('Person in charge who handled this donation'),
                            
                        Forms\Components\DatePicker::make('donation_date')
                            ->label('Date of Donation')
                            ->required()
                            ->default(now())
                            ->helperText('When was this donation received?'),
                            
                        Forms\Components\TextInput::make('amount')
                            ->label('Donation Amount')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->placeholder('100.00')
                            ->helperText('The monetary amount donated'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donor_name')
                    ->label('Donor')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Donation $record): string => $record->organization_name ?? 'Individual'),
                    
                Tables\Columns\TextColumn::make('pic_name')
                    ->label('Contact Person')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('donation_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable()
                    ->alignEnd()
                    ->color('success')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recorded On')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('donation_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('donation_date')
                    ->label('Filter by Year')
                    ->options(function () {
                        return Donation::query()
                            ->selectRaw('YEAR(donation_date) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year');
                    })
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereYear('donation_date', $data['value']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->color('success'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Donation'),
            ])
            ->emptyStateHeading('No donations yet')
            ->emptyStateDescription('Once you add donations, they will appear here.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDonations::route('/'),
        ];
    }
}