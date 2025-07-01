<?php

namespace App;

use Illuminate\Support\Collection;

class Templates
{
    /** @var Collection|MEME_template[] */
    public Collection $templates;

    public function __construct(array $templates = [])
    {
        $this->templates = collect($templates);
    }

    public function add(MEME_template $template): void
    {
        $this->templates->push($template);
    }

    public function all(): Collection
    {
        return $this->templates;
    }
}
