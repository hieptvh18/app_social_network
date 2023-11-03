<?php

namespace Modules\Core\Enums;

enum UserMissionStatusEnum: string
{
    case TODO = 'TODO';
    case DOING = 'DOING';
    case WAITING_FOR_APPROVE = 'WAITING_FOR_APPROVE';
    case DONE = 'DONE';
    case EXPIRED = 'EXPRIED';
}
