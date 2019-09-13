<div class="card mb-2">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}...
            </h5>

            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    @csrf
                    <button type="submit" class="btn btn-dark" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="body">{{$reply->body}}</div>
    </div>
</div>