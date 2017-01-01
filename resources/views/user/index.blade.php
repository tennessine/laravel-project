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
                    管理员列表
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}">编辑</a> | <a data-toggle="modal" data-target="#confirmDeleteModal" }}" data-id="{{ $user->id }}">删除</a>
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
                                    <form action="{{ route('user.destroy', 0) }}" method="post">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
