@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Create Product') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" name="description" class="form-control" placeholder="Descriprion">
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input type="number" name="stock" class="form-control" placeholder="Stock">
                            </div>
                            <div class="form-group">
                                <label for="">Product Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection