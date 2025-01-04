<?php

namespace App\Enums;

enum RequestStatus: string
{
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
    case WAITING = 'waiting';
    case CANCELED = 'canceled';
    case CONFIRMED = 'confirmed';
}
