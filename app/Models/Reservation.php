<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'reservation_date',
        'start_time',
        'end_time',
        'purpose',
        'proposal_file',
        'status',
        'admin_notes',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
            'approved' => 'bg-success-subtle text-success-emphasis border border-success-subtle',
            'rejected' => 'bg-danger-subtle text-danger-emphasis border border-danger-subtle',
            'cancelled' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle',
            default => 'bg-light text-dark',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->reservation_date)->translatedFormat('d F Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        $start = substr($this->start_time, 0, 5);
        $end = substr($this->end_time, 0, 5);
        return "{$start} - {$end} WIB";
    }

    /**
     * Generate direct WhatsApp message link
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (!$this->user || !$this->user->formatted_phone) {
            return null;
        }

        $phone = $this->user->formatted_phone;
        $statusUpper = strtoupper($this->status_label);
        $date = $this->formatted_date;
        $time = $this->formatted_time;
        $room = $this->room->name ?? 'Ruangan Kampus';
        $peminjam = $this->user->name;
        $notes = $this->admin_notes ? "\nCatatan: " . $this->admin_notes : '';

        $message = "Halo Sdr/i *{$peminjam}*,\n\n"
            . "Pemberitahuan dari *Bagian Sarpras Kampus* terkait permohonan peminjaman ruangan:\n\n"
            . "• Ruangan: *{$room}*\n"
            . "• Tanggal: *{$date}*\n"
            . "• Waktu: *{$time}*\n"
            . "• Keperluan: {$this->purpose}\n"
            . "• Status: *{$statusUpper}*\n"
            . $notes . "\n\n"
            . "Terima kasih.\n_CampusRoom Management System_";

        return "https://wa.me/{$phone}?text=" . rawurlencode($message);
    }
}
