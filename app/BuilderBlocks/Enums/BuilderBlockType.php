<?php
namespace App\BuilderBlocks\Enums;

enum BuilderBlockType: string
{
    case Slider = 'slider';
    case Testimonial = 'testimonial';
    case Product = 'product';
    case Accordion = 'accordion';
    case Tabs = 'tabs';
    case Form = 'form';
    case Posts = 'posts';
    case Portfolio = 'portfolio';
    case Gallery = 'gallery';
    case Container = 'container';

    // Small components
    case Heading = 'heading';
    case TextEditor = 'text_editor';
    case Image = 'image';
    case Button = 'button';
    case Icon = 'icon';
    case Divider = 'divider';
    case Spacer = 'spacer';
    case Video = 'video';
    case Html = 'html';
}