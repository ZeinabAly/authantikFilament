<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\{Employee, User};
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\EmployeeResource\Pages;
use App\Filament\Resources\Admin\EmployeeResource\RelationManagers;
use App\Filament\Resources\Admin\EmployeeResource\RelationManagers\AbsencesRelationManager;
use App\Filament\Resources\Admin\EmployeeResource\RelationManagers\CalendrierEmployeesRelationManager;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Employés';

    protected static ?int $navigationSort = 8;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Information personnelles')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label("Choisir ou créer un utilisateur")
                        ->options(function () {
                            return User::doesntHave('employee') // ← ceux qui n'ont pas de relation avec 'employee'
                                ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->preload()
                        ->required()
                        ->reactive() // clé pour préremplir les autres champs!
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('Nom')
                                ->required(),
                            Forms\Components\TextInput::make('phone')
                                ->label('Phone')
                                ->required(),
                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email(),
                            Forms\Components\TextInput::make('password')
                                ->label('Mot de passe')
                                ->password()
                                ->required()
                                ->minLength(8),
                            Forms\Components\FileUpload::make('image')
                                ->label('Image')
                                ->image()
                                ->disk('public') 
                                ->directory('uploads/users') 
                                ->imageEditor()
                                ->required()
                                ->imageEditorAspectRatios([
                                    '16:9',
                                    '4:3',
                                    '1:1',
                                ]),
                        ])
                        ->createOptionAction(function ($action) {
                            return $action
                                ->modalHeading('Créer un nouvel utilisateur');
                                // ->mutateFormDataUsing(function (array $data): array {
                                //     $data['password'] = Hash::make($data['password']);
                                //     return $data;
                                // });
                        })
                        ->afterStateUpdated(function ($state, callable $set) {
                            $user = \App\Models\User::find($state);
                    
                            if ($user) {
                                $set('name', $user->name);
                                $set('email', $user->email);
                                $set('phone', $user->phone);
                                $set('password', $user->password);
                            }
                        }),
                    Forms\Components\TextInput::make('name')
                        ->label('Nom complet')
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email(),
                    Forms\Components\TextInput::make('password')
                        ->label('Mot de passe')
                        ->password()
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public') 
                        ->directory('uploads/employees') 
                        ->imageEditor()
                        ->required()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                ])->columns(2),

            Forms\Components\Section::make('Information professionnelles')
                ->schema([
                    Forms\Components\Select::make('fonction')
                        ->label('Fonction')
                        ->options([
                            'caissier' => 'Caissier',
                            'serveur' => 'Serveur',
                            'livreur' => 'Livreur',
                        ])->placeholder('-- Sélectionnez une option --')
                        ->required(),
                    Forms\Components\TextInput::make('salaire')
                        ->label('Salaire')
                        ->numeric()
                        ->suffix('GNF'),
                    Forms\Components\DatePicker::make('embauche_at')
                        ->label('Date d\embauche')
                        ->required(),
                    Forms\Components\DatePicker::make('finContrat_at')
                        ->label('Fin du contrat'),
                    Forms\Components\Select::make('competences')
                        ->label('Compétences')
                        ->options(
                            [
                                'rapidité' => 'Rapidité d\'exécution',
                                'ponctualite' => 'Ponctualité',
                                'assiduite' => 'Assiduité',
                                'polyvalence' => 'Polyvalence',
                                'organisation' => 'Organisation',
                                'communication' => 'Communication',
                            ]
                        )
                        ->multiple(),
                    Forms\Components\Textarea::make('description')
                        ->label('Description'),
                ])->columns(2),

            Forms\Components\Section::make('Réseaux sociaux')
                ->description('Les liens des réseaux sociaux')
                ->schema([
                    Forms\Components\TextInput::make('facebook')
                        ->label('Facebook')
                        ->prefixIcon('heroicon-o-x-mark'),
                    Forms\Components\TextInput::make('twitter')
                        ->label('Twitter')
                        ->prefixIcon('heroicon-o-x-mark'),
                    Forms\Components\TextInput::make('snapchat')
                        ->label('Snapchat')
                        ->prefixIcon('heroicon-o-x-mark'),
                    Forms\Components\TextInput::make('instagram')
                        ->label('Instagram')
                        ->prefixIcon('heroicon-o-x-mark'),
                ])->columns(2),  
                
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Employee::latest())
            ->columns([
                Tables\Columns\ImageColumn::make('image') 
                    ->label('Image')
                    ->square(),
                Tables\Columns\TextColumn::make('user.name') 
                    ->label('Nom d\'utilisateur')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name') 
                    ->label('Nom')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone') 
                    ->label('Phone')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email') 
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fonction') 
                    ->label('Fonction')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            'caissier' => 'Caissier',
                            'serveur' => 'Serveur',
                            'livreur' => 'Livreur',
                        ];
                        return $options[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('competences') 
                    ->label('Compétences')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $options = [
                            'rapidité' => 'Rapidité d\'exécution',
                            'ponctualite' => 'Ponctualité',
                            'assiduite' => 'Assiduité',
                            'polyvalence' => 'Polyvalence',
                            'organisation' => 'Organisation',
                            'communication' => 'Communication',
                        ];
                        
                        return $options[$state] ?? $state;
                    }),
                
                Tables\Columns\TextColumn::make('description') 
                    ->label('Description')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salaire') 
                    ->label('Salaire')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF'),
                Tables\Columns\TextColumn::make('embauche_at') 
                    ->label('Date d\'embauche')
                    ->dateTime('d/m/Y')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finContrat_at') 
                    ->label('Fin de contrat')
                    ->dateTime()
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('email')
                    ->label('Email'),
                Tables\Filters\Filter::make('fonction')
                    ->label('Fonction')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager']) || auth()->user()->id === $record->id),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                    Tables\Actions\Action::make('viewProfile')
                    ->label('Voir profil')
                    ->icon('heroicon-o-user')
                    ->url(fn (Employee $employee) => route('filament.admin.resources.admin.employees.profile', ['record' => $employee->user->id]))
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager']) || auth()->user()->id === $record->id),
                    Tables\Actions\RestoreAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(
                fn ($record) => static::getUrl('view', ['record' => $record])
            );
    }

    public static function getRelations(): array
    {
        return [
            CalendrierEmployeesRelationManager::class,
            AbsencesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
            'profile' => Pages\EmployeeProfile::route('/{record}/profile'),
        ];
    }

}
