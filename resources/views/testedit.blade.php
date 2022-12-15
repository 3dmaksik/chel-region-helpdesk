<form method="POST" action="{{ route('cabinet.update',$item->id) }}">
    @method('PATCH')
    @csrf
<input type="text" name="description" id="" value="{{ $item->description }}">
<input type="submit" value="Отправить">
</form>
@if($errors->any())
{{ $errors->first() }}
@endif
