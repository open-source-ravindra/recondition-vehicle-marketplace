<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';
    const ROLE_USER = 'user';

    // Check roles
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    // Scope for role filtering
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeStaff($query)
    {
        return $query->where('role', self::ROLE_STAFF);
    }

    // Get role display name
    public function getRoleNameAttribute()
    {
        $roles = [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_STAFF => 'Staff',
            self::ROLE_USER => 'User',
        ];
        return $roles[$this->role] ?? $this->role;
    }

    // Relationships
    public function createdTransfers()
    {
        return $this->hasMany(VehicleTransfer::class, 'created_by');
    }

    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(TransferDocument::class, 'uploaded_by');
    }
}
