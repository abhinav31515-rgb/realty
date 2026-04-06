<?php
namespace App\Enums;
enum PropertyStatus: string {
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case SOLD = 'sold';
    case REJECTED = 'rejected';
}
