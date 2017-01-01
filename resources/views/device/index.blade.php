@extends('layouts.app') @section('content')
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
                    设备列表
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>设备号</th>
                                <th>设备名称</th>
                                <!-- <th>设备阀值</th> -->
                                <th>用户名</th>
                                <th>密码</th>
                                <th>添加时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($devices as $device)
                            <tr>
                                <td>{{ $device->clientID }}</td>
                                <td>{{ $device->name }}</td>
                                <!-- <td>{{ $device->threshold }}</td> -->
                                <td>{{ $device->username }}</td>
                                <td>{{ $device->password }}</td>
                                <td>{{ $device->created_at }}</td>
                                <td>{!! $device->status ? '<b style="color: green;">Running</b>': '<b style="color: red;">Stopped</b>' !!}</td>
                                <td>
                                    <a href="{{ route('device.show', ['id' => $device->id, 'date' => $date]) }}">查看</a> | <a href="{{ route('device.edit', ['id' => $device->id]) }}">编辑</a> | <a data-toggle="modal" data-target="#confirmDeleteModal" }}" data-id="{{ $device->id }}">删除</a> | <a data-toggle="modal" data-target="#sendCommandModal" data-cid="{{ $device->clientID }}">发送指令</a>
                                </td>
                            </tr>
                            @empty
                            <td colspan="8" align="center">您还没有添加任何设备</td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="links" style="text-align: center;">
                        {{ $devices->links() }}
                    </div>
                </div>
                <div class="modal fade" id="sendCommandModal" tabindex="-1" role="dialog" aria-labelledby="sendCommandModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="sendCommandModalLabel">New message</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="topic" class="control-label">发送到:</label>
                                        <input type="text" class="form-control" id="topic" />
                                    </div>
                                    <div class="form-group">
                                        <label for="command" class="control-label">指令:</label>
                                        <textarea class="form-control" id="command"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary sendCommand">发送指令</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>确认要删除吗?</h4>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('device.destroy', 0) }}" method="post">
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
                <script src="js/mqttws31.js"></script>
                <script src="js/components/layer-v3.0.1/layer/layer.js"></script>
                <script>

                var user = {!! $superUser !!};

                var mqtt = {
                    connect: function() {
                        console.log('connecting...');
                        this.bindEvent();
                        // Create a client instance
                        this.client = new Paho.MQTT.Client(location.hostname, 8083, user.clientID);

                        // set callback handlers
                        this.client.onConnectionLost = onConnectionLost;
                        this.client.onMessageDelivered = onMessageDelivered;

                        // connect the client
                        this.client.connect({
                            userName: user.username,
                            password: user.password,
                            onSuccess: onConnect
                        });

                        // called when the client connects
                        function onConnect() {
                            // Once a connection has been made, make a subscription and send a message.
                            console.log("connected");
                        }

                        // called when the client loses its connection
                        function onConnectionLost(responseObject) {
                            if (responseObject.errorCode !== 0) {
                                console.log("onConnectionLost:" + responseObject.errorMessage);
                            }
                        }

                        function onMessageDelivered() {
                            layer.msg('指令发送成功', {icon: 1});
                        }
                    },
                    sendCommand: function(topic, command) {
                        var message = new Paho.MQTT.Message(command);
                        message.destinationName = topic;
                        message.qos = 2;
                        this.client.send(message);
                    },
                    bindEvent: function() {
                        var _this = this;
                        $('#sendCommandModal').on('show.bs.modal', function (event) {
                            var a = $(event.relatedTarget);
                            var clientID = a.data('cid');
                            _this.topic = 'device/' + clientID;

                            _this.modal = $(this);
                            _this.modal.find('.modal-title').text('给设备 ' + clientID + ' 发送指令')
                            _this.modal.find('.modal-body input').val(_this.topic);

                            var $submitButton = _this.modal.find('.modal-footer .sendCommand');
                            $submitButton.click(_this.handleSubmit.bind(_this));
                        });
                    },
                    handleSubmit: function() {
                        var isConnected = this.client.isConnected();
                        if(!isConnected) {
                            layer.msg('未连接到服务器', {icon: 5});
                            return;
                        }

                        this.command = this.modal.find('.modal-body textarea').val();

                        if(this.command.length === 0) {
                            layer.msg('指令不能为空', {icon: 5});
                            return;
                        }

                        this.sendCommand(this.topic, this.command);
                        this.modal.modal('hide');
                    }
                };

                mqtt.connect();
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
