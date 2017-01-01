@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加设备权限
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
                    <form action="{{ route('acl.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="ipaddr">ip地址</label>
                            <input type="text" class="form-control" id="ipaddr" name="ipaddr" value="" />
                        </div>
                        <div class="form-group">
                            <label for="allow">允许/阻止</label>
                            <select class="form-control" name="allow">
                                <option value="1">允许</option>
                                <option value="0">阻止</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">用户名</label>
                            <input type="text" class="form-control" id="username" name="username" value="" />
                        </div>
                        <div class="form-group">
                            <label for="clientID">设备号</label>
                            <input type="text" class="form-control" id="clientID" name="clientID" value="" />
                        </div>
                        <div class="form-group">
                            <label for="access">访问权限</label>
                            <select class="form-control" name="access">
                                <option value="1">订阅</option>
                                <option value="2">发布</option>
                                <option value="3">订阅+发布</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="topic">主题</label>
                            <input type="text" class="form-control" id="topic" name="topic" value="" />
                        </div>
                        <button type="submit" class="btn btn-default">添加设备权限</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
