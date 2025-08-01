<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location', // Keeping location
        'reporting_date',
        'color_code',
        'logo_path',
        'mission',
        'vision',
        'carbon_footprint_reduction',
        'sustainable_sourcing',
        'energy_efficiency',
        'waste_reduction',
        'employee_engagement',
        'other_sustainability_goals',
        'subsidiaries_list' // Storing subsidiaries as JSON
    ];

    protected $casts = [
        'reporting_date' => 'date',
        'carbon_footprint_reduction' => 'boolean',
        'sustainable_sourcing' => 'boolean',
        'energy_efficiency' => 'boolean',
        'waste_reduction' => 'boolean',
        'employee_engagement' => 'boolean',
        'subsidiaries_list' => 'array',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'sustainability_goals', 
        'logo_url', 
        'subsidiaries_count',
        'active_programs'
    ];

    // Sustainability Goals Methods
    public function getSustainabilityGoalsAttribute(): array
    {
        return array_filter([
            'Carbon Footprint Reduction' => $this->carbon_footprint_reduction ? 'Yes' : 'No',
            'Sustainable Sourcing' => $this->sustainable_sourcing ? 'Yes' : 'No',
            'Energy Efficiency' => $this->energy_efficiency ? 'Yes' : 'No',
            'Waste Reduction' => $this->waste_reduction ? 'Yes' : 'No',
            'Employee Engagement' => $this->employee_engagement ? 'Yes' : 'No',
            'Other Goals' => $this->other_sustainability_goals ?: null
        ]);
    }

    public function getActiveProgramsAttribute(): string
    {
        $active = collect([
            'Carbon' => $this->carbon_footprint_reduction,
            'Sourcing' => $this->sustainable_sourcing,
            'Energy' => $this->energy_efficiency,
            'Waste' => $this->waste_reduction,
            'Employees' => $this->employee_engagement
        ])->filter()->keys();

        return $active->isNotEmpty() ? $active->join(', ') : 'None';
    }

    public function hasSustainabilityGoals(): bool
    {
        return collect([
            $this->carbon_footprint_reduction,
            $this->sustainable_sourcing,
            $this->energy_efficiency,
            $this->waste_reduction,
            $this->employee_engagement,
            $this->other_sustainability_goals
        ])->contains(true);
    }

    // Logo URL
    public function getLogoUrlAttribute(): string
    {
        return $this->logo_path 
            ? asset('storage/'.$this->logo_path)
            : $this->generateAvatarUrl();
    }

    protected function generateAvatarUrl(): string
    {
        return 'https://ui-avatars.com/api/?'.http_build_query([
            'name' => $this->name,
            'color' => 'FFFFFF',
            'background' => str_replace('#', '', $this->color_code ?? '000000'),
            'size' => 150
        ]);
    }

    // Subsidiaries Management (using JSON, no relations)
    public function subsidiaries(): Collection
    {
        return collect($this->subsidiaries_list ?? []);
    }

    public function getSubsidiariesCountAttribute(): int
    {
        return $this->subsidiaries()->count();
    }

    public function addSubsidiary(array $subsidiary): self
    {
        $this->update([
            'subsidiaries_list' => $this->subsidiaries()->push($subsidiary)->all()
        ]);
        
        return $this;
    }

    public function removeSubsidiary(string $name): self
    {
        $this->update([
            'subsidiaries_list' => $this->subsidiaries()
                ->reject(fn($sub) => ($sub['name'] ?? '') === $name)
                ->values()
                ->all()
        ]);
        
        return $this;
    }

    public function updateSubsidiary(string $name, array $newData): self
    {
        $this->update([
            'subsidiaries_list' => $this->subsidiaries()
                ->map(fn($sub) => ($sub['name'] ?? '') === $name 
                    ? array_merge($sub, $newData) 
                    : $sub)
                ->all()
        ]);
        
        return $this;
    }

    public function findSubsidiary(string $name): ?array
    {
        return $this->subsidiaries()->firstWhere('name', $name);
    }

    public function hasSubsidiary(string $name): bool
    {
        return $this->subsidiaries()->contains('name', $name);
    }
}