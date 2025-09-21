<?php

namespace App\Filament\Clusters\WebContent\Resources\BlogResource\Pages;

use App\Filament\Clusters\WebContent\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
}
