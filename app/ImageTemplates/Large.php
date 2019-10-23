<?php

namespace App\ImageTemplates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Large implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(1200, 700)->insert('images/wm.png', 'center');
    }
}