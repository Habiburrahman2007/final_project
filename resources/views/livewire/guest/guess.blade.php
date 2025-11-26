<div>
    <div class="text-center mt-3">
        <h6>
            <span><a href="{{ route('register') }}">Daftarkan akunmu</a></span> untuk membuka fitur tambahan seperti
            menulis dan memberi like artikel
        </h6>
    </div>

    <div class="p-3 mb-3">
        <div class="input-group w-100 mb-3 d-flex flex-column flex-md-row align-items-start align-items-md-center">
            <input type="text" class="form-control me-2 w-100 w-md-50" placeholder="Cari judul artikel atau penulis..."
                wire:model.live="search" style="height: 38px;" />
            <div class="btn-group my-1 mt-md-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-filter"></i> {{ $category }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#" wire:click.prevent="setCategory('All')">All</a></li>
                    @foreach ($categories as $cat)
                        <li>
                            <a class="dropdown-item" href="#"
                                wire:click.prevent="setCategory('{{ $cat }}')">
                                {{ $cat }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if ($articles->isEmpty())
            <div class="card">
                <div class="card-body">
                    @if ($category !== 'All')
                        Tidak ada artikel di kategori "{{ $category }}" yang sesuai pencarian.
                    @elseif($search)
                        Tidak ada artikel yang sesuai dengan kata kunci "{{ $search }}".
                    @else
                        Belum ada artikel yang ditulis.
                    @endif
                </div>
            </div>
        @else
            <div class="row g-4 mt-2">
                @foreach ($articles as $article)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card blog-card rounded-3 overflow-hidden shadow-sm h-100">
                            <a href="{{ route('detail-article-guest', $article->slug) }}"
                                class="text-decoration-none text-dark">
                                <img class="card-img-top img-fluid rounded-top-3 object-cover"
                                    style="height: 200px; width: 100%; object-fit: cover;"
                                    src="{{ !empty($article->image) && file_exists(storage_path('app/public/' . $article->image))
                                        ? asset('storage/' . $article->image)
                                        : asset('img/Login.jpg') }}"
                                    alt="{{ $article->title }}">
                                <div class="card-body">
                                    <h4 class="card-title text-secondary">{{ $article->title }}</h4>
                                    @php
                                        $clean = $article->content;
                                        $clean = preg_replace_callback(
                                            '/<ol>(.*?)<\/ol>/s',
                                            function ($matches) {
                                                preg_match_all('/<li>(.*?)<\/li>/s', $matches[1], $items);
                                                $result = '';
                                                foreach ($items[1] as $i => $text) {
                                                    $result .= $i + 1 . '. ' . strip_tags($text) . ' ';
                                                }
                                                return $result;
                                            },
                                            $clean,
                                        );
                                        $clean = preg_replace('/<ul>(.*?)<\/ul>/s', '', $clean);
                                        $clean = preg_replace('/<li>(.*?)<\/li>/s', '• $1 ', $clean);
                                        $preview = \Illuminate\Support\Str::limit(strip_tags($clean), 120);
                                    @endphp
                                    <p class="card-text text-secondary">{{ $preview }}</p>
                                    <span class="badge {{ $article->category->color }}">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            </a>
                            <div
                                class="card-footer border-0 d-flex justify-content-between align-items-center px-3 pb-3">
                                <div class="btn-group">
                                    <a href="{{ route('register') }}" class="btn btn-link p-2 text-decoration-none">
                                        <i class="bi bi-heart text-secondary"></i>
                                        <small class="text-muted ms-1">{{ $article->likes->count() }}</small>
                                    </a>
                                    <button type="button" class="btn btn-link p-2 text-decoration-none">
                                        <i class="bi bi-chat text-secondary"></i>
                                        <small class="text-muted">{{ $article->comments->count() }}</small>
                                    </button>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('detail-profile-guest', $article->user->slug) }}"
                                        class="d-flex align-items-center text-decoration-none">
                                        <img src="{{ $article->user->photo_profile ? asset('storage/' . $article->user->photo_profile) : asset('img/default-avatar.jpeg') }}"
                                            class="rounded-circle me-2"
                                            style="width: 35px; height: 35px; object-fit: cover;" alt="Author">
                                        <small class="fw-semibold text-secondary">
                                            {{ \Illuminate\Support\Str::limit($article->user->name, 10, '...') }}
                                        </small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>'<div class="text-center mt-4">
        @if ($totalArticles > count($articles))
            <button wire:click="loadMore" class="btn btn-outline-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="loadMore">
                    Load More
                </span>
                <span wire:loading wire:target="loadMore" class="hidden">
                    <i class="fa fa-spinner fa-spin me-1"></i> Loading...
                </span>
            </button>
        @else
            <p class="text-muted">No more articles</p>
        @endif
    </div>'
</div>
