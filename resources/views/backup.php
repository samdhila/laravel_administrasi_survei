<option value="3">Beta</option>
<option value="4">Charlie</option>
<option value="5">Delta</option>
<option value="6">Edison</option>
<option value="7">Foxrot</option>
@foreach($users as $surveyor)
<option value="{{ $surveyor->id }}">{{ $surveyor->name }}</option>
@endforeach