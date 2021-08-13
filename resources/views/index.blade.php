@extends('layout')

@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Созданные заказы и доставки за {{now()->format('Y')}} год</h5>
    </div>
    <div class="card-body">
        {{--<form method="get" action="/">
            <div class="form-group row">
                <div class="col-md-2">
                    <label class="form-group-float-label is-visible">Тип</label>
                    <select class="select" name="date_period">
                        <option value="1">Неделя</option>
                        <option value="2">Месяц</option>
                        <option value="3">Год</option>
                    </select>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-1">
                <div class="form-group form-group-float">
                    <label>Применить</label>
                    <span class="input-group-append">
                        <button type="submit" class="btn alert-primary text-primary-800"><i class="icon-checkmark"></i> </button>
                    </span>
                </div>
                </div>
            </div>

        </form>--}}
        <div class="chart-container">
            <div class="chart has-fixed-height" id="columns_basic"></div>
        </div>
    </div>
    <script>
        var columns_basic_element = document.getElementById('columns_basic');

        if (columns_basic_element) {

            // Initialize chart
            var columns_basic = echarts.init(columns_basic_element);


            //
            // Chart config
            //

            // Options
            columns_basic.setOption({

                // Define colors
                color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 40,
                    top: 35,
                    bottom: 0,
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Заказы', 'Доставки'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: [{!! $dates !!}],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Заказы',
                        type: 'bar',
                        data: [{{$orders->implode(',')}}],
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        },
                        /*markLine: {
                            data: [{type: 'average', name: 'Average'}]
                        }*/
                    },
                    {
                        name: 'Доставки',
                        type: 'bar',
                        data: [{{$deliveries->implode(',')}}],
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'top',
                                    textStyle: {
                                        fontWeight: 500
                                    }
                                }
                            }
                        },
                        /*markLine: {
                            data: [{type: 'average', name: 'Average'}]
                        }*/
                    }
                ]
            });
        }
    </script>
</div>
@endsection