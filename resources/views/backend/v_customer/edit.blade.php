@extends('backend.v_layouts.app')
@section('content')
    <!-- contentAwal -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('customer.updateakun', $edit->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <h4 class="card-title"> {{$judul}} </h4>
                            <div class="form-group">
                                <label>Nama Customer</label>
                                <input type="text" name="nama"
                                    value="{{old('nama', $edit->user->nama) }}"
                                    class="form-control @error('nama')is-invalid @enderror"
                                    placeholder="Masukkan Nama Customer">
                                @error('nama')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Perbaharui</button>
                                <a href="{{ route('backend.customer.index') }}">
                                    <button type="button" class="btn btn-secondary">Kembali</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- contentAkhir -->
@endsection