<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class WebContent extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $clusterBreadcrumb = 'Content';
    protected static ?string $navigationLabel = 'Content';
    protected static ?int $navigationSort = 2;
}
