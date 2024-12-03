<?php
namespace App\Enums;

enum DateFormats: string
{
    case FORMAT_YMD = 'Y-m-d';
    case FORMAT_DMY_SLASH = 'd/m/Y';
    case FORMAT_MDY_DASH = 'm-d-Y';
    case FORMAT_DMY_DASH = 'd-m-Y';
    case FORMAT_MDY_SLASH = 'm/d/Y';
    case FORMAT_YMD_SLASH = 'Y/m/d';
    case FORMAT_MD_Y = 'M d, Y';
    case FORMAT_D_M_Y = 'd M Y';
}
