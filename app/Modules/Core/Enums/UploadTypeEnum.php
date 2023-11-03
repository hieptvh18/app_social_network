<?php

namespace Modules\Core\Enums;

enum UploadTypeEnum: string
{
    case CHANEL = 'CHANEL';
    case AVATAR = 'AVATAR';
    case blog = 'blog';
    case category = 'category';
    case BANNER = 'BANNER';
    case PROMOTION_AVATAR = 'PROMOTION_AVATAR';
    case PROMOTION_BANNER = 'PROMOTION_BANNER';
    case PROMOTION_REPORT = 'PROMOTION_REPORT';
    case CATEGORY_BOOK = 'CATEGORY_BOOK';
    case EBOOK_BOOK = 'EBOOK_BOOK';
    case QUIZ_SUBJECT = 'QUIZ_SUBJECT';
    case QUIZ_SKILL = 'QUIZ_SKILL';
    case QUIZ_TOPIC = 'QUIZ_TOPIC';
    case QUIZ_LEVEL = 'QUIZ_LEVEL';
    case QUIZ_MAJOR = 'QUIZ_MAJOR';
    case CORE_FEEDBACK = 'CORE_FEEDBACK';
    case BIZAPP = 'BIZAPP';
    // case EXAM = 'PRIVATE';
}
