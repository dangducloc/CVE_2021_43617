<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MEME_template extends Model
{
    public string $template_name;
    public string $template_path;
    public string $template_url;
    public string $file_size;

    public function __construct(array $attributes = [])
    {
        $this->template_name = $attributes['template_name'] ?? null;
        $this->template_path = $attributes['template_path'] ?? null;
        $this->template_url  = $attributes['template_url'] ?? null;
        $this->file_size     = $attributes['file_size'] ?? null;
    }
    public function toArray(): array
{
    return [
        'template_name' => $this->template_name,
        'template_path' => $this->template_path,
        'template_url'  => $this->template_url,
        'file_size'     => $this->file_size,
    ];
}

}
