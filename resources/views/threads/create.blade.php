@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form method="POST" action="/threads">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea class="form-control" name="body" id="body" rows="8"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Publish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
