<div class="row justify-content-center">

    <div class="col-sm-6">
        <div class="form-group">
            <label for="male_reserved_room">Number of Male Reserved Rooms</label>
            <input type="number" name="male_reserved_room" id="male_reserved_room"
                value="{{ old('male_reserved_room') }}"
                class="form-control @error('male_reserved_room') is-invalid @enderror">

            @error('male_reserved_room')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label for="female_reserved_room">Number Female of Reserved Rooms</label>
            <input type="number" name="female_reserved_room" id="female_reserved_room"
                value="{{ old('female_reserved_room') }}"
                class="form-control @error('female_reserved_room') is-invalid @enderror">

            @error('female_reserved_room')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    
    <div class="col-sm-12">
        <hr>
        <h5><strong>Selection Criteria</strong></h5>

        <div class="mt-4 row justify-content-center">
            <div class="col-8">
                <select class="form-control select2" data-placeholder="Select Group Criteria" multiple name="criteria" id="criteria">
                    <option value="disabled">Disabled</option>
                    <option value="foreigner">Foreigner</option>
                    <option value="fresher">Fresher</option>
                    <option value="sponsor">Sponsor</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="certificate_award">Certificate</option>
                    <option value="diploma_award">Diploma</option>
                    <option value="bachelor_award">Bachelor</option>
                </select>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger">Remove Field</button>
            </div>
        </div>

        <button type="button" class="float-right btn btn-primary">Add Field</button>

    </div>

    <div class="col-12">
        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Save <i
                    class="ri-save-line align-middle"></i></button>
        </div>
    </div>
</div>
