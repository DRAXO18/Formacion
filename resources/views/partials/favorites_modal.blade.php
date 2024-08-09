<div class="modal fade" id="favoritesModal" tabindex="-1" aria-labelledby="favoritesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="favoritesModalLabel">Mis Favoritos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($favorites->isEmpty())
                    <p>No tienes vistas favoritas.</p>
                @else
                    <ul class="list-group">
                        @foreach($favorites as $favorite)
                            <li class="list-group-item">
                                <a href="{{ route($favorite->view_name, json_decode($favorite->view_params, true)) }}">
                                    {{ ucwords(str_replace('.', ' ', $favorite->view_name)) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
