@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    修改设备
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
                    <form action="{{ route('device.update', $device->id) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="clientID">设备号</label>
                            <input type="text" class="form-control" id="clientID" name="clientID" value="{{ $device->clientID }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">设备名称</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $device->name }}" />
                        </div>
                        <div class="form-group">
                            <label for="username">用户名</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $device->username }}" />
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="text" class="form-control" id="password" name="password" value="{{ $device->password }}" />
                        </div>
                        <div class="form-group">
                            <label for="threshold">设备阀值</label>
                            <input type="text" class="form-control" id="threshold" name="threshold" value="{{ $device->threshold }}" placeholder="a,b" />
                            <span class="help-block">
                                <strong>低于a, 显示为红色; a到b之间, 显示为蓝色; 高于b显示为绿色</strong>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-default">更新设备</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
