<a title="Click to mark as favorite question (click again to undo)"
    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
    onclick="event.preventDefault();document.getElementById('favorite-question-{{ $model->id }}').submit();">
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form id="favorite-question-{{ $model->id }}" action="/questions/{{ $model->id }}/favorites" style="display:none;" method="POST">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>