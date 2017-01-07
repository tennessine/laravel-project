@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            设备状态统计
                        </div>
                        <div class="col-md-6">
                            <input class="pull-right laydate-icon" id="date" value="{{ $time }}" />
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="container">
                        <!-- 图表 -->
                    </div>

                    <!-- 指示灯 -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="led-box">
                                <div class="led-gray"></div>
                                <p>故障报警</p>
                            </div>
                            <div class="led-box">
                                <div class="led-gray"></div>
                                <p>机器运转</p>
                            </div>
                            <div class="led-box">
                                <div class="led-gray"></div>
                                <p>机器做工</p>
                            </div>
                            <div class="led-box">
                                <div class="led-gray"></div>
                                <p>禁止运行</p>
                            </div>
                        </div>
                    </div>

                    <script src="/js/components/laydate-v1.1/laydate/laydate.js"></script>
                    <script>

                    var baseUrl = "{{ route('device.show', ['id' => $device->id, 'time' => '?']) }}";

                    var payload = {{ $payload }};

                    $(function() {
                        var data = {!! $data !!};

                        var arr = new Array(24);
                        arr.fill(0);

                        for(var i = 0; i < 24; i++) {
                            if(data[i]) {
                                var index = parseInt(data[i].at);
                                arr[index] = parseFloat(data[i].percent);
                            }
                        }

                        var chart = Highcharts.chart('container', {

                            title: {
                                text: '{{ $device->clientID }} ({{ $device->name }}) 状态统计'
                            },

                            subtitle: {
                                text: ''
                            },

                            xAxis: {
                                title: {
                                    text: '时间'
                                },
                                labels: {
                                    y: 20,
                                    style: {
                                        color: '#19a0f5',//颜色
                                        fontSize:'14px'  //字体
                                    }
                                },
                                categories: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12',
                                    '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'
                                ],
                            },

                            yAxis: {
                                title: {
                                    text: '开机百分比'
                                },
                                labels: {
                                    style: {
                                        fontSize:'16px',
                                        fontFamily:'微软雅黑'
                                    }
                                },
                                lineWidth: 1
                            },
			    credits: {  
          			enabled:false  
			    },  
                            series: [{
                                type: 'column',
                                colorByPoint: true,
                                data: arr,
                                showInLegend: false,
                                zones: [{
                                        value: {{ $threshold_min }},
                                        color: '#ff0000'
                                    }, {
                                        value: {{ $threshold_max }},
                                        color: '#0000ff'
                                    }, {
                                        color: '#00ff00'
                                    }
                                ],
                            }]

                        });

                        // 选择日期
                        laydate({
                            elem: '#date',
                            format: 'YYYY-MM-DD',
                            istoday: false,
                            min: '{{ $range->min }}',
                            max: '{{ $range->max }}',
                            choose: function(date) {
                                location.href = baseUrl.replace('?', date);
                            }
                        });

                        function addClassByBit(position, className) {
                            position = position - 1;
                            var bit = (payload & (1 << position) ) >> position;
                            var $led = $('.led-box div').eq(position);
                            if(bit) {
                                $led.removeClass('led-gray');
                                $led.addClass(className);
                            }
                        }

                        addClassByBit(1, 'led-red');
                        addClassByBit(2, 'led-green');
                        addClassByBit(3, 'led-yellow');
                        addClassByBit(4, 'led-red on');
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
