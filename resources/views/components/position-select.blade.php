<div class="form-group">
    <label for="position">Position</label>
    <select id="position" name="position_id" class="form-control">
        @foreach($positions ?? [] as $position)
            <option value="{{ $position->id }}"
                @selected($position->id==old('position_id', null))
            >{{ $position->name }}</option>
        @endforeach
    </select>
    @error('position_id')
    <p style="color: red">{{ $message }}</p>
    @enderror
</div>
