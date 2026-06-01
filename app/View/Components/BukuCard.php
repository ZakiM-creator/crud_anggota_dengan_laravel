<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BukuCard extends Component
{
    /**
     * Property untuk menyimpan object Buku
     * Public agar bisa diakses di view
     * 
     * @var \App\Models\Buku
     */
    public $buku;

    /**
     * Property untuk mengontrol tampilan tombol actions
     * Default true = tombol ditampilkan
     * 
     * @var bool
     */
    public $showActions;

    /**
     * Create a new component instance.
     * 
     * Constructor ini dipanggil saat component digunakan
     * Parameter akan otomatis di-inject dari attribute component
     * 
     * @param \App\Models\Buku $buku - Object buku dari database
     * @param bool $showActions - Flag untuk menampilkan tombol (default: true)
     */
    public function __construct($buku, $showActions = true)
    {
        // Assign parameter ke property class
        $this->buku = $buku;
        $this->showActions = $showActions;
    }

    /**
     * Get the view / contents that represent the component.
     * 
     * Method ini menentukan view mana yang akan di-render
     * Laravel otomatis mencari di: resources/views/components/buku-card.blade.php
     * 
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.buku-card');
    }
}
