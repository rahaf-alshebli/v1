@extends('layouts.app')
@extends('layouts.nav')
@section('content')

    <div class="container col-6 mt-2">


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">Edit University details
                <a href="{{ route('admin.university-Admin.index') }}" class="btn btn-secondary btn-sm float-end"> Go Back</a>
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('admin.university-Admin.update', $universities->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')


                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">name_university : </label>
                        <div class="col-sm-10">
                            <input type="text" name="id_university" class="form-control"
                            value="{{ $universities->id }}" hidden />
                            <input type="text" name="name_university" class="form-control"
                                value="{{ $universities->name_university }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-label-form">name_of_building: </label>
                        <div class="col-sm-10">
                        <select name="room_id" class="form-control">
                            <option  disabled="">Select a name_of_building</option>
                            @foreach ($rooms as $room)
                                <option value="{{  $room->id }}">{{  $room->name_of_building }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
              
                  




                    <div class="row mb-4">
                        <label class="col-sm-2 col-label-form">address : </label>
                        <div class="col-sm-10">
                            <textarea type="text" name="university_address" class="form-control" rows="3">{{ $universities->university_address}}</textarea>
                        </div>
                    </div>




                    <img src="{{ asset('images/' . $universities->university_image) }}" width="100" class="img-thumbnail" />
                    <div class="form-group mb-5">
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                    <input type="hidden" name="hidden_img" value="{{ $universities->university_image }}" />

                    <div class="text-center">
                        <input type="submit" class="btn btn-primary float-end" value="Update details" />
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
