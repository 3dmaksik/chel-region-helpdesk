<form method="POST" enctype="multipart/form-data" action="{{ route('cabinet.store') }}">
    @csrf
<input type="file" name="images[]" class="custom-file-input" id="chooseFile" multiple />
<input type="text" name="description" id="" />
<input type="submit" value="Отправить">
</form>
@if($errors->any())
{{ $errors->first() }}
@endif
