@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    设备默认阀值设置
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('device.threshold') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="threshold">设备默认阀值</label>
                            <input type="text" class="form-control" id="threshold" name="threshold" value="{{ $threshold }}" placeholder="格式: 0.2,0.8" />
                        </div>

                        <button type="submit" class="btn btn-default">设置设备默认阀值</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
