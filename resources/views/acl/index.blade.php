@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    设备权限列表
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>允许/禁止</th>
                                <th>ip地址</th>
                                <th>用户名</th>
                                <th>设备号</th>
                                <th>权限</th>
                                <th>主题</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($acls as $acl)
                            <tr>
                                <td>{{ $acl->allowString }}</td>
                                <td>{{ $acl->ipaddr }}</td>
                                <td>{{ $acl->username }}</td>
                                <td>{{ $acl->clientID }}</td>
                                <td>{{ $acl->accessString }}</td>
                                <td>{{ $acl->topic }}</td>
                                <td>
                                    <a href="{{ route('acl.edit', $acl->id) }}">编辑</a> | <a data-toggle="modal" data-target="#confirmDeleteModal" }}" data-id="{{ $acl->id }}">删除</a>
                                </td>
                            </tr>
                            @empty
                            <td colspan="7" align="center">您还没有添加任何设备</td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>确认要删除吗?</h4>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('acl.destroy', 0) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        <button type="submit" class="btn btn-primary">确认</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
                            var button = $(event.relatedTarget);
                            var id = button.data('id');
                            var $form = $(this).find('form');
                            var action = $form.attr('action');
                            action = action.substring(0, action.lastIndexOf('/') + 1) + id;
                            $form.attr('action', action);
                        });
                    </script>
                    <div class="links" style="text-align: center;">
                        {{ $acls->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
