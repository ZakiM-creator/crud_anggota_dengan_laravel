{{--
    Blade Component: Buku Card
    Properties:
    - $buku: Object Buku dari database
    - $showActions: Boolean untuk menampilkan tombol actions
--}}

<div class="card shadow-sm border-0 h-100">
    <div class="card-body">

        {{-- COVER ICON --}}
        <div class="text-center mb-3">
            <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-primary" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                </svg>
            </div>
        </div>

        {{-- JUDUL BUKU --}}
        <h5 class="card-title fw-bold mb-2 text-truncate" title="{{ $buku->judul }}">
            {{ $buku->judul }}
        </h5>

        {{-- PENGARANG --}}
        <p class="text-muted small mb-2">
            <i class="bi bi-person"></i>
            {{ $buku->pengarang }}
        </p>

        {{-- BADGE KATEGORI --}}
        <div class="mb-3">
            <span class="badge bg-info text-dark">
                {{ $buku->kategori }}
            </span>
        </div>

        {{-- HARGA --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted small">Harga:</span>
            <span class="fw-bold text-success">{{ $buku->harga_format }}</span>
        </div>

        {{-- STOK --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted small">Stok:</span>
            <span class="fw-semibold">{{ $buku->stok }} unit</span>
        </div>

        {{-- STATUS KETERSEDIAAN --}}
        <div class="mb-3">
            {!! $buku->status_stok_badge !!}
        </div>

        {{-- BUTTON ACTIONS (Conditional) --}}
        @if($showActions)
        <div class="d-grid gap-2">
            <a href="{{ route('buku.show', $buku->id) }}"
                class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye"></i> Detail
            </a>
            <a href="{{ route('buku.edit', $buku->id) }}"
                class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
        @endif

    </div>
</div>