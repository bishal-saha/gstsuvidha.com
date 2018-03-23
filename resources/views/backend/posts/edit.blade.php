@extends('layouts.backend')

@section('title', '| Edit Post')

@section('page')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Edit Post</h1>
            <hr>

            <div class="form-group">
                <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="PUT">
                @csrf
                <div class="form-group">
                    <label for="title" class="col-form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
                    @if ($errors->has('title'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="body" class="col-form-label">Post Body</label>
                    <textarea role="5" cols="5" name="body" id="body" class="form-control {{ $errors->has('body')?'is-invalid':'' }}">{{ old('body') }}</textarea>
                    @if($errors->has('body'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('body') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-lg">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection