<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'title',
        'description',
        'location',
        'company',
        'logo',
        'salary',
        'job_type',
    ];

    protected $casts = [
        'salary' => 'integer',
    ];

    /**
     * Label jenis pekerjaan untuk kebutuhan tampilan badge.
     */
    public function getJobTypeLabelAttribute(): string
    {
        return match ($this->job_type) {
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'contract' => 'Kontrak',
            'internship' => 'Magang',
            default => ucfirst((string) $this->job_type),
        };
    }

    /**
     * Kelas warna Bootstrap untuk badge jenis pekerjaan.
     */
    public function getJobTypeBadgeAttribute(): string
    {
        return match ($this->job_type) {
            'full-time' => 'bg-primary',
            'part-time' => 'bg-warning text-dark',
            'contract' => 'bg-info text-dark',
            'internship' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Gaji terformat rupiah, atau null bila lowongan tidak mencantumkan gaji.
     */
    public function getSalaryFormattedAttribute(): ?string
    {
        if ($this->salary === null) {
            return null;
        }

        return 'Rp '.number_format($this->salary, 0, ',', '.');
    }
}
